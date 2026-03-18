<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\RevisionRequest;
use App\Models\RevisionReview;
use App\Models\User;
use App\Services\RevisionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\LayoutEditorAssignment;

class SubmissionController extends Controller
{
    // ─── Statuses that mean "still active / in-progress" ───────────────────
    private const ACTIVE_STATUSES = [
        Submission::STATUS_SUBMITTED,
        Submission::STATUS_UNDER_REVIEW,
        Submission::STATUS_REVISIONS_REQUESTED,
        'revision_under_review',
        'with_managing_editor',
        'layout_editing',
        'layout_review',
        Submission::STATUS_AUTHOR_CONFIRMATION,
    ];

    // ─── Similarity scoring ─────────────────────────────────────────────────
    private const SIMILARITY_THRESHOLD = 3; // shared meaningful words needed
    private const SIMILARITY_STOP_WORDS = [
        'about','after','again','among','being','between','during','every',
        'further','having','other','their','there','these','through','under',
        'using','where','which','while','with','that','this','from','have',
        'will','been','were','they','than','into','more','also','such','both',
        'then','when','study','analysis','research','paper','review','based',
    ];

    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();

        $search = trim($request->input('search', ''));

        $submissions = $user->submissionsAsAuthor()
            ->when($search, function ($q) use ($search) {
                $q->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhereRaw("LPAD(CAST(id AS CHAR), 5, '0') LIKE ?", ["%{$search}%"]);
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'submitted'              => $user->submissionsAsAuthor()->where('status', Submission::STATUS_SUBMITTED)->count(),
            'under_review'           => $user->submissionsAsAuthor()->where('status', Submission::STATUS_UNDER_REVIEW)->count(),
            'revisions_requested'    => $user->submissionsAsAuthor()->where('status', Submission::STATUS_REVISIONS_REQUESTED)->count(),
            'revision_under_review'  => $user->submissionsAsAuthor()->where('status', 'revision_under_review')->count(),
            'accepted'               => $user->submissionsAsAuthor()->where('status', Submission::STATUS_ACCEPTED)->count(),
            'rejected'               => $user->submissionsAsAuthor()->where('status', Submission::STATUS_REJECTED)->count(),
            'published'              => $user->submissionsAsAuthor()->where('status', Submission::STATUS_PUBLISHED)->count(),
        ];

        return view('submissions.index', compact('submissions', 'stats', 'search'));
    }

    // ───────────────────────────────────────────────────────────────────────
    //  CREATE
    // ───────────────────────────────────────────────────────────────────────
    public function create(): View
    {
        $fieldOptions = \App\Models\EditorExpertise::getFieldOptions();

        // Restriction 1: one active submission at a time
        $activeSubmission = Submission::where('author_id', Auth::id())
            ->whereIn('status', self::ACTIVE_STATUSES)
            ->latest()
            ->first();

        return view('submissions.create', compact('fieldOptions', 'activeSubmission'));
    }

    // ───────────────────────────────────────────────────────────────────────
    //  STORE
    // ───────────────────────────────────────────────────────────────────────
    public function store(Request $request): RedirectResponse|View
    {
        // ── Restriction 1 (server-side guard) ──────────────────────────────
        $activeSubmission = Submission::where('author_id', Auth::id())
            ->whereIn('status', self::ACTIVE_STATUSES)
            ->first();

        if ($activeSubmission) {
            return redirect()->route('submissions.create')
                ->with('error', 'You already have an active submission. Please wait until it is published or rejected before submitting a new manuscript.');
        }

        // ── Validate ────────────────────────────────────────────────────────
        $validated = $request->validate([
            'title'                   => ['required', 'string', 'max:255'],
            'abstract'                => ['required', 'string'],
            'keywords'                => ['nullable', 'string', 'max:255'],
            'research_field'          => ['required', 'string', 'in:' . implode(',', array_keys(\App\Models\EditorExpertise::getFieldOptions()))],
            'file'                    => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'similarity_acknowledged' => ['nullable', 'in:1'],
        ]);

        // ── Restriction 2: similar article check ───────────────────────────
        $similarSubmissions = $this->findSimilarSubmissions(
            $validated['title'],
            $validated['abstract'] ?? ''
        );

        if ($similarSubmissions->isNotEmpty() && ! $request->boolean('similarity_acknowledged')) {
            $fieldOptions = \App\Models\EditorExpertise::getFieldOptions();
            return redirect()->back()
                ->with('warning', 'Similar submissions found. Please review them before acknowledging.')
                ->withInput()
                ->with('similarSubmissions', $similarSubmissions)
                ->with('fieldOptions', $fieldOptions);
        }

        // ── File upload ─────────────────────────────────────────────────────
        $file = $request->file('file');
        $nextSubmissionNumber = $this->getNextSubmissionNumber();

        // Generate original submission filename: MS-2026-001.pdf
        $originalFileName = $this->generateOriginalSubmissionFileName($nextSubmissionNumber, $file);
        $path = $file->storeAs('submissions/' . Auth::id(), $originalFileName, 'local');

        // ── Persist ─────────────────────────────────────────────────────────
        $submission = Submission::create([
            'author_id'          => Auth::id(),
            'title'              => $validated['title'],
            'abstract'           => $validated['abstract'],
            'keywords'           => $validated['keywords'] ?? null,
            'research_field'     => $validated['research_field'],
            'file_path'          => $path,
            'file_name'          => $originalFileName,
            'original_file_path' => $path,
            'original_file_name' => $originalFileName,
            'status'             => Submission::STATUS_SUBMITTED,
            'submitted_at'       => now(),
            'submission_number'  => $nextSubmissionNumber,
        ]);

        // ── Notify chief editors ────────────────────────────────────────────
        $chiefEditors = User::whereHas('roles', fn ($q) => $q->where('name', 'editor-in-chief'))->get();
        foreach ($chiefEditors as $ce) {
            \App\Models\Notification::create([
                'user_id'         => $ce->id,
                'role'            => 'editor-in-chief',
                'title'           => 'New Manuscript Submitted',
                'message'         => "A new manuscript has been submitted: \"{$submission->title}\" by " . Auth::user()->name . ".",
                'type'            => 'info',
                'notifiable_id'   => $submission->id,
                'notifiable_type' => Submission::class,
            ]);
        }

        return redirect()->route('submissions.index')
            ->with('success', 'Submission created successfully.');
    }

    // ───────────────────────────────────────────────────────────────────────
    //  AJAX – real-time similarity check
    //  Route: GET /submissions/check-similarity
    // ───────────────────────────────────────────────────────────────────────
    public function checkSimilarity(Request $request)
    {
        $request->validate([
            'title'    => 'nullable|string|max:500',
            'abstract' => 'nullable|string|max:3000',
        ]);

        $similar = $this->findSimilarSubmissions(
            $request->input('title', ''),
            $request->input('abstract', '')
        );

        return response()->json([
            'similar' => $similar->map(fn ($s) => [
                'id'             => $s->id,
                'title'          => $s->title,
                'status'         => Submission::statusOptions()[$s->status] ?? $s->status,
                'research_field' => $s->research_field,
                'created_at'     => $s->created_at->format('M d, Y'),
            ]),
        ]);
    }

    // ───────────────────────────────────────────────────────────────────────
    //  SHOW
    // ───────────────────────────────────────────────────────────────────────
    public function show(Submission $submission): View|RedirectResponse
    {
        $this->authorizeView($submission);
        $submission->load([
            'author',
            'reviews.reviewer',
            'reviewAssignments.reviewer',
            'revisionRequests.revisionReviews.reviewer',
            'appeals',
        ]);

        return view('submissions.show', compact('submission'));
    }

    // ───────────────────────────────────────────────────────────────────────
    //  EDIT / UPDATE
    // ───────────────────────────────────────────────────────────────────────
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
            'title'          => ['required', 'string', 'max:255'],
            'abstract'       => ['required', 'string'],
            'keywords'       => ['nullable', 'string', 'max:255'],
            'research_field' => ['required', 'string', 'in:' . implode(',', array_keys(\App\Models\EditorExpertise::getFieldOptions()))],
            'file'           => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
        ]);

        $data = [
            'title'          => $validated['title'],
            'abstract'       => $validated['abstract'],
            'keywords'       => $validated['keywords'] ?? null,
            'research_field' => $validated['research_field'],
        ];

        if ($request->hasFile('file')) {
            if ($submission->file_path) {
                Storage::disk('local')->delete($submission->file_path);
            }
            $file              = $request->file('file');
            $data['file_path'] = $file->store('submissions/' . Auth::id(), 'local');
            $data['file_name'] = $file->getClientOriginalName();
        }

        $submission->update($data);

        return redirect()->route('submissions.show', $submission)
            ->with('success', 'Submission updated.');
    }

    // ───────────────────────────────────────────────────────────────────────
    //  REVISIONS
    // ───────────────────────────────────────────────────────────────────────
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
            'file'                => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'revision_notes'      => ['required', 'string', 'max:1000'],
            'revision_request_id' => ['required', 'exists:revision_requests,id'],
        ]);

        $revisionRequest = RevisionRequest::findOrFail($validated['revision_request_id']);

        if ($revisionRequest->submission_id !== $submission->id) {
            return back()->with('error', 'Invalid revision request.');
        }

        $file = $request->file('file');

        // Generate revision filename: MS-2026-023-R2.pdf
        $revisionFileName = $this->generateRevisionFileName($submission, $file);
        $path = $file->storeAs('submissions/' . Auth::id() . '/revisions', $revisionFileName, 'local');

        RevisionService::processRevisionSubmission(
            $revisionRequest,
            $path,
            $validated['revision_notes'],
            $revisionFileName
        );

        return redirect()->route('submissions.show', $submission)
            ->with('success', 'Revised manuscript submitted successfully. Awaiting review.');
    }

    // ───────────────────────────────────────────────────────────────────────
    //  LAYOUT
    // ───────────────────────────────────────────────────────────────────────
    public function downloadLayout(Submission $submission)
    {
        if ($submission->author_id !== Auth::id()) {
            abort(403);
        }

        $layoutAssignment = $submission->layoutEditorAssignments()
            ->where('status', \App\Models\LayoutEditorAssignment::STATUS_COMPLETED)
            ->latest('completed_at')
            ->first();

        if (! $layoutAssignment || ! Storage::disk('local')->exists($layoutAssignment->layout_file_path)) {
            abort(404, 'Layout file not found.');
        }

        return response()->download(
            Storage::disk('local')->path($layoutAssignment->layout_file_path),
            $layoutAssignment->layout_file_name ?? 'layout.pdf'
        );
    }

    public function downloadRevisionFile(Submission $submission, RevisionRequest $revisionRequest)
    {
        $this->authorizeView($submission);

        if ($revisionRequest->submission_id !== $submission->id) {
            abort(404);
        }

        if (! $revisionRequest->revised_file_path || ! Storage::disk('local')->exists($revisionRequest->revised_file_path)) {
            abort(404, 'Revision file not found.');
        }

        return response()->download(
            Storage::disk('local')->path($revisionRequest->revised_file_path),
            $revisionRequest->revised_file_name ?? 'revision.pdf'
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
            'status'                 => Submission::STATUS_WITH_MANAGING_EDITOR,
            'managing_editor_status' => 'ready_to_publish',
        ]);

        $managingEditor = $submission->managingEditor;
        if ($managingEditor) {
            \App\Models\Notification::create([
                'user_id'         => $managingEditor->id,
                'role'            => 'managing-editor',
                'title'           => '✅ Author Confirmed Layout — Ready to Publish',
                'message'         => "Author has confirmed the layout for \"{$submission->title}\". The manuscript is now ready for final publishing.",
                'type'            => 'success',
                'notifiable_id'   => $submission->id,
                'notifiable_type' => Submission::class,
            ]);
        }

        return redirect()->route('submissions.show', $submission)
            ->with('success', 'Layout confirmed! Your manuscript is now awaiting final publishing by the managing editor.');
    }

    // ───────────────────────────────────────────────────────────────────────
    //  PRIVATE HELPERS
    // ───────────────────────────────────────────────────────────────────────

    private function authorizeView(Submission $submission): void
    {
        /** @var User $user */
        $user = Auth::user();

        if ($submission->author_id !== $user->id && ! $user->isEditor() && ! $user->isAdmin()) {
            abort(403);
        }
    }

    /**
     * Find existing submissions whose title/abstract share significant
     * keywords with the given text.
     */
    private function findSimilarSubmissions(string $title, string $abstract = ''): \Illuminate\Support\Collection
    {
        if (strlen(trim($title)) < 5) {
            return collect();
        }

        $words = collect(preg_split('/\W+/', strtolower($title . ' ' . $abstract)))
            ->filter(fn ($w) => strlen($w) >= 5 && ! in_array($w, self::SIMILARITY_STOP_WORDS))
            ->unique()
            ->values();

        if ($words->isEmpty()) {
            return collect();
        }

        $candidates = Submission::where('author_id', '!=', Auth::id())
            ->where('status', '!=', 'rejected')
            ->where(function ($q) use ($words) {
                foreach ($words->take(10) as $word) {
                    $q->orWhere('title', 'like', '%' . $word . '%');
                }
            })
            ->get();

        return $candidates->map(function ($sub) use ($words) {
            $titleHaystack    = strtolower($sub->title);
            $abstractHaystack = strtolower($sub->abstract ?? '');
            $score = 0;

            foreach ($words as $word) {
                if (str_contains($titleHaystack, $word)) {
                    $score += 2;
                } elseif (str_contains($abstractHaystack, $word)) {
                    $score += 1;
                }
            }

            $sub->_similarity_score = $score;
            return $sub;
        })
        ->filter(fn ($s) => $s->_similarity_score >= self::SIMILARITY_THRESHOLD)
        ->sortByDesc('_similarity_score')
        ->take(5)
        ->values();
    }

    public function uploadSignedCtf(Request $request, Submission $submission): RedirectResponse
    {
        if ($submission->author_id !== Auth::id()) {
            abort(403);
        }

        if ($submission->managing_editor_status !== 'ctf_sent') {
            return back()->with('error', 'No CTF is awaiting your signature.');
        }

        $request->validate([
            'signed_ctf_file' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
        ]);

        $file = $request->file('signed_ctf_file');
        $path = $file->storeAs(
            'ctf-signed',
            'signed-ctf-' . $submission->id . '-' . time() . '.' . $file->getClientOriginalExtension(),
            'local'
        );

        $submission->update([
            'managing_editor_status' => 'ctf_returned',
            'ctf_signed_file_path'   => $path,
            'ctf_signed_file_name'   => $file->getClientOriginalName(),
            'ctf_returned_at'        => now(),
        ]);

        $managingEditor = $submission->managingEditor;
        if ($managingEditor) {
            \App\Models\Notification::create([
                'user_id'         => $managingEditor->id,
                'role'            => 'managing-editor',
                'title'           => '✅ Signed CTF Returned by Author',
                'message'         => "The author has uploaded the signed Copyright Transfer Form for \"{$submission->title}\". You may now assign a layout editor.",
                'type'            => 'success',
                'notifiable_id'   => $submission->id,
                'notifiable_type' => Submission::class,
            ]);
        }

        return redirect()->route('submissions.index')
            ->with('success', 'Signed CTF uploaded. The managing editor has been notified.');
    }

    public function authorConfirm(Request $request, Submission $submission)
    {
        if ($submission->author_id !== Auth::id()) {
            abort(403);
        }

        $assignment = LayoutEditorAssignment::findOrFail($request->assignment_id);

        \Illuminate\Support\Facades\DB::table('layout_editor_assignments')
            ->where('id', $assignment->id)
            ->update([
                'author_status'      => 'confirmed',
                'author_feedback_at' => now(),
            ]);

        $submission->update([
            'status'                 => Submission::STATUS_WITH_MANAGING_EDITOR,
            'managing_editor_status' => 'ready_to_publish',
        ]);

        $managingEditor = $submission->managingEditor;
        if ($managingEditor) {
            \App\Models\Notification::create([
                'user_id'         => $managingEditor->id,
                'role'            => 'managing-editor',
                'title'           => '✅ Author Confirmed Layout — Ready to Publish',
                'message'         => "Author has confirmed the layout for \"{$submission->title}\". The manuscript is now ready for final publishing.",
                'type'            => 'success',
                'notifiable_id'   => $submission->id,
                'notifiable_type' => Submission::class,
            ]);
        }

        return back()->with('success', 'Layout confirmed. The Managing Editor will proceed with publication.');
    }

    public function authorRequestRevision(Request $request, Submission $submission)
    {
        if ($submission->author_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'author_feedback' => 'required|string|max:2000',
        ]);

        $assignment = LayoutEditorAssignment::findOrFail($request->assignment_id);

        \Illuminate\Support\Facades\DB::table('layout_editor_assignments')
            ->where('id', $assignment->id)
            ->update([
                'author_status'      => 'revision_requested',
                'author_feedback'    => $request->author_feedback,
                'author_feedback_at' => now(),
            ]);

        $managingEditor = $submission->managingEditor;
        if ($managingEditor) {
            \App\Models\Notification::create([
                'user_id'         => $managingEditor->id,
                'role'            => 'managing-editor',
                'title'           => '⚠ Author Requested Layout Revision',
                'message'         => "The author has requested revisions for \"{$submission->title}\".",
                'type'            => 'warning',
                'notifiable_id'   => $submission->id,
                'notifiable_type' => Submission::class,
            ]);
        }

        return back()->with('success', 'Revision request sent to the Managing Editor.');
    }

    // ───────────────────────────────────────────────────────────────────────
    //  HELPER: Generate and track submission numbers
    // ───────────────────────────────────────────────────────────────────────
    private function getNextSubmissionNumber(): int
    {
        $lastSubmission = Submission::where('submission_number', '!=', null)
            ->orderByDesc('submission_number')
            ->first();

        return ($lastSubmission?->submission_number ?? 0) + 1;
    }

    /**
     * Ensure submission has a submission_number, assign if missing
     */
    private function ensureSubmissionNumber(Submission $submission): int
    {
        if ($submission->submission_number !== null) {
            return $submission->submission_number;
        }

        // Submission doesn't have a number - assign one
        $nextNumber = $this->getNextSubmissionNumber();
        $submission->update(['submission_number' => $nextNumber]);
        return $nextNumber;
    }

    /**
     * Count how many revisions have been submitted for this submission.
     * This is used to determine the revision number (R1, R2, etc.)
     */
    private function countSubmissionRevisions(Submission $submission): int
    {
        return RevisionRequest::where('submission_id', $submission->id)
            ->whereNotNull('revised_at')
            ->count();
    }

    /**
     * Generate filename for original submission in format: [Journal]-D-YYYY-###.ext
     * Example: [Journal]-D-2026-023.pdf
     */
    private function generateOriginalSubmissionFileName(int $submissionNumber, \Illuminate\Http\UploadedFile $file): string
    {
        $year = now()->year;
        $paddedNumber = str_pad($submissionNumber, 3, '0', STR_PAD_LEFT);
        $extension = $file->getClientOriginalExtension();

        return "[Journal]-D-{$year}-{$paddedNumber}.{$extension}";
    }

    /**
     * Generate filename in format: [Journal]-D-YYYY-###R#.ext
     * Example: [Journal]-D-2026-023R2.pdf
     */
    private function generateRevisionFileName(Submission $submission, \Illuminate\Http\UploadedFile $file): string
    {
        $year = now()->year;
        $submissionNumber = str_pad($this->ensureSubmissionNumber($submission), 3, '0', STR_PAD_LEFT);
        $revisionCount = $this->countSubmissionRevisions($submission) + 1;
        $extension = $file->getClientOriginalExtension();

        return "[Journal]-D-{$year}-{$submissionNumber}R{$revisionCount}.{$extension}";
    }
}
