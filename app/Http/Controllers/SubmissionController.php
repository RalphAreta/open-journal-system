<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\RevisionRequest;
use App\Models\RevisionReview;
use App\Models\User; // Added for type hinting
use App\Services\RevisionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Added for direct ID access
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SubmissionController extends Controller
{
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();

        $submissions = $user->submissionsAsAuthor()
            ->latest()
            ->paginate(15);

        return view('submissions.index', compact('submissions'));
    }

    public function create(): View
    {
        $fieldOptions = \App\Models\EditorExpertise::getFieldOptions();
        return view('submissions.create', compact('fieldOptions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'abstract' => ['required', 'string'],
            'keywords' => ['nullable', 'string', 'max:255'],
            'research_field' => ['required', 'string', 'in:' . implode(',', array_keys(\App\Models\EditorExpertise::getFieldOptions()))],
            'file' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
        ]);

        $file = $request->file('file');
        // Using Auth::id() prevents the 'Undefined method id' error
        $path = $file->store('submissions/' . Auth::id(), 'local');

       $submission = Submission::create([
    'author_id' => Auth::id(),
    'title' => $validated['title'],
    'abstract' => $validated['abstract'],
    'keywords' => $validated['keywords'] ?? null,
    'research_field' => $validated['research_field'],
    'file_path' => $path,
    'file_name' => $file->getClientOriginalName(),
    'original_file_path' => $path,
    'original_file_name' => $file->getClientOriginalName(),
    'status' => Submission::STATUS_SUBMITTED,
    'submitted_at' => now(),
]);

// Notify all chief editors
$chiefEditors = User::whereHas('roles', fn($q) => $q->where('name', 'editor-in-chief'))->get();
foreach ($chiefEditors as $ce) {
    \App\Models\Notification::create([
        'user_id'         => $ce->id,
        'title'           => ' New Manuscript Submitted',
        'message'         => "A new manuscript has been submitted: \"{$submission->title}\" by " . Auth::user()->name . ".",
        'type'            => 'info',
        'notifiable_id'   => $submission->id,
        'notifiable_type' => Submission::class,
    ]);
}

return redirect()->route('submissions.index')->with('success', 'Submission created successfully.');
    }

    public function show(Submission $submission): View|RedirectResponse
    {
        $this->authorizeView($submission);
        $submission->load([
            'author',
            'reviews.reviewer',
            'reviewAssignments.reviewer',
            'revisionRequests.revisionReviews.reviewer',
            'appeals'
        ]);

        return view('submissions.show', compact('submission'));
    }

    public function edit(Submission $submission): View|RedirectResponse
    {
        $this->authorizeView($submission);
        if (! $submission->isEditableByAuthor()) {
            return redirect()->route('submissions.show', $submission)
                ->with('error', 'This submission can no longer be edited.');
        }

        $fieldOptions = \App\Models\EditorExpertise::getFieldOptions();
        return view('submissions.edit', compact('submission', 'fieldOptions'));
    }

    public function update(Request $request, Submission $submission): RedirectResponse
    {
        $this->authorizeView($submission);
        if (! $submission->isEditableByAuthor()) {
            return redirect()->route('submissions.show', $submission)
                ->with('error', 'This submission can no longer be edited.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'abstract' => ['required', 'string'],
            'keywords' => ['nullable', 'string', 'max:255'],
            'research_field' => ['required', 'string', 'in:' . implode(',', array_keys(\App\Models\EditorExpertise::getFieldOptions()))],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
        ]);

        $data = [
            'title' => $validated['title'],
            'abstract' => $validated['abstract'],
            'keywords' => $validated['keywords'] ?? null,
            'research_field' => $validated['research_field'],
        ];

        if ($request->hasFile('file')) {
            if ($submission->file_path) {
                Storage::disk('local')->delete($submission->file_path);
            }
            $file = $request->file('file');
            $data['file_path'] = $file->store('submissions/' . Auth::id(), 'local');
            $data['file_name'] = $file->getClientOriginalName();
        }

        $submission->update($data);

        return redirect()->route('submissions.show', $submission)->with('success', 'Submission updated.');
    }

    private function authorizeView(Submission $submission): void
    {
        /** @var User $user */
        $user = Auth::user();

        if ($submission->author_id !== $user->id && ! $user->isEditor() && ! $user->isAdmin()) {
            abort(403);
        }
    }

    public function revisions(Submission $submission): View|RedirectResponse
    {
        if ($submission->author_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $submission->load('revisionRequests.requestedBy');
        return view('submissions.revisions', compact('submission'));
    }

    public function submitRevision(Request $request, Submission $submission): RedirectResponse
    {
        if ($submission->author_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if ($submission->status !== Submission::STATUS_REVISIONS_REQUESTED) {
            return back()->with('error', 'This submission does not require revisions.');
        }

        $validated = $request->validate([
            'file' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'revision_notes' => ['required', 'string', 'max:1000'],
            'revision_request_id' => ['required', 'exists:revision_requests,id'],
        ]);

        $revisionRequest = RevisionRequest::findOrFail($validated['revision_request_id']);

        if ($revisionRequest->submission_id !== $submission->id) {
            return back()->with('error', 'Invalid revision request.');
        }

        $file = $request->file('file');
        $path = $file->store('submissions/' . Auth::id() . '/revisions', 'local');

        RevisionService::processRevisionSubmission(
            $revisionRequest,
            $path,
            $validated['revision_notes']
        );

        return redirect()->route('submissions.show', $submission)
            ->with('success', 'Revised manuscript submitted successfully. Awaiting review.');
    }

    public function downloadLayout(Submission $submission)
    {
        if ($submission->author_id !== Auth::id()) {
            abort(403);
        }

        $layoutAssignment = $submission->layoutEditorAssignments()
            ->where('status', \App\Models\LayoutEditorAssignment::STATUS_COMPLETED)
            ->latest('completed_at')
            ->first();

        if (!$layoutAssignment || !\Illuminate\Support\Facades\Storage::disk('local')->exists($layoutAssignment->layout_file_path)) {
            abort(404, 'Layout file not found.');
        }

        return response()->download(
            \Illuminate\Support\Facades\Storage::disk('local')->path($layoutAssignment->layout_file_path),
            $layoutAssignment->layout_file_name ?? 'layout.pdf'
        );
    }

    public function confirmLayout(Submission $submission): RedirectResponse
    {
        if ($submission->author_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if ($submission->status !== Submission::STATUS_AUTHOR_CONFIRMATION) {
            return back()->with('error', 'This submission is not awaiting author confirmation.');
        }

        $submission->update([
            'status' => Submission::STATUS_PUBLISHED,
            'published_at' => now(),
        ]);

        return redirect()->route('submissions.show', $submission)
            ->with('success', 'Congratulations! Your manuscript has been published successfully.');
    }
}
