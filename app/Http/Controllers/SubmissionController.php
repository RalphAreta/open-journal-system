<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\RevisionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SubmissionController extends Controller
{
    public function index(Request $request): View
    {
        $submissions = $request->user()
            ->submissionsAsAuthor()
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
        $path = $file->store('submissions/' . $request->user()->id, 'local');

        Submission::create([
            'author_id' => $request->user()->id,
            'title' => $validated['title'],
            'abstract' => $validated['abstract'],
            'keywords' => $validated['keywords'] ?? null,
            'research_field' => $validated['research_field'],
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'status' => Submission::STATUS_SUBMITTED,
            'submitted_at' => now(),
        ]);

        return redirect()->route('submissions.index')->with('success', 'Submission created successfully.');
    }

    public function show(Submission $submission): View|RedirectResponse
    {
        $this->authorizeView($submission);
        $submission->load(['author', 'reviews.reviewer', 'reviewAssignments.reviewer']);

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
            $data['file_path'] = $file->store('submissions/' . $request->user()->id, 'local');
            $data['file_name'] = $file->getClientOriginalName();
        }

        $submission->update($data);

        return redirect()->route('submissions.show', $submission)->with('success', 'Submission updated.');
    }

    private function authorizeView(Submission $submission): void
    {
        $user = request()->user();
        if ($submission->author_id !== $user->id && ! $user->isEditor() && ! $user->isAdmin()) {
            abort(403);
        }
    }

    /**
     * Show revision requests for a submission (author).
     */
    public function revisions(Submission $submission): View|RedirectResponse
    {
        if ($submission->author_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $submission->load('revisionRequests.requestedBy');
        return view('submissions.revisions', compact('submission'));
    }

    /**
     * Store revised manuscript (author).
     */
    public function submitRevision(Request $request, Submission $submission): RedirectResponse
    {
        if ($submission->author_id !== $request->user()->id) {
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

        // Store the revised file
        $file = $request->file('file');
        $path = $file->store('submissions/' . $request->user()->id . '/revisions', 'local');

        // Create new submission version or update existing
        $revisedSubmission = Submission::create([
            'author_id' => $request->user()->id,
            'title' => $submission->title,
            'abstract' => $submission->abstract,
            'keywords' => $submission->keywords,
            'research_field' => $submission->research_field,
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'status' => Submission::STATUS_UNDER_REVIEW,
            'assigned_editor_id' => $submission->assigned_editor_id,
            'submitted_at' => now(),
        ]);

        // Update revision request
        $revisionRequest->update([
            'revised_submission_id' => $revisedSubmission->id,
            'revised_at' => now(),
            'revision_notes' => $validated['revision_notes'],
        ]);

        // Update original submission status
        $submission->update([
            'status' => Submission::STATUS_SUBMITTED,
        ]);

      // Notify the specific person who requested the revision
\App\Models\Notification::create([
    'user_id'         => $revisionRequest->requested_by_user_id,
    'title'           => '📄 Revised Manuscript Submitted',
    'message'         => "The author has submitted a revised manuscript for \"{$submission->title}\".\n\nAuthor Notes: {$validated['revision_notes']}",
    'type'            => 'info',
    'notifiable_id'   => $submission->id,
    'notifiable_type' => Submission::class,
]);

return redirect()->route('submissions.show', $submission)
    ->with('success', 'Revised manuscript submitted successfully. Awaiting editor review.');
    }
}
