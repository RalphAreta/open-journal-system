<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ReviewAssignment;
use App\Models\Submission;
use App\Models\RevisionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReviewController extends Controller
{
    /**
     * List submissions assigned to the current user for review (reviewer).
     */
    public function index(Request $request): View
    {
        $assignments = $request->user()
            ->reviewAssignments()
            ->with(['submission.author'])
            ->latest()
            ->paginate(15);

        return view('reviews.index', compact('assignments'));
    }

    /**
     * Show submission and form to submit review (reviewer).
     */
    public function create(ReviewAssignment $assignment): View|RedirectResponse
    {
        if ($assignment->reviewer_id !== request()->user()->id) {
            abort(403);
        }
        if ($assignment->status === ReviewAssignment::STATUS_COMPLETED) {
            return redirect()->route('reviews.index')->with('info', 'You have already submitted this review.');
        }

        $assignment->load('submission.author');
        $submission = $assignment->submission;

        return view('reviews.create', compact('assignment', 'submission'));
    }

    /**
     * Store review (reviewer).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'review_assignment_id' => ['required', 'exists:review_assignments,id'],
            'recommendation' => ['required', 'in:accept,minor_revisions,major_revisions,reject'],
            'comments_for_author' => ['nullable', 'string'],
            'comments_for_editor' => ['nullable', 'string'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
        ]);

        $assignment = ReviewAssignment::findOrFail($validated['review_assignment_id']);
        if ($assignment->reviewer_id !== $request->user()->id) {
            abort(403);
        }
        if ($assignment->status === ReviewAssignment::STATUS_COMPLETED) {
            return redirect()->route('reviews.index')->with('error', 'Review already submitted.');
        }

        Review::create([
            'submission_id' => $assignment->submission_id,
            'reviewer_id' => $request->user()->id,
            'review_assignment_id' => $assignment->id,
            'recommendation' => $validated['recommendation'],
            'comments_for_author' => $validated['comments_for_author'] ?? null,
            'comments_for_editor' => $validated['comments_for_editor'] ?? null,
            'rating' => $validated['rating'] ?? null,
            'submitted_at' => now(),
        ]);

        $assignment->update([
            'status' => ReviewAssignment::STATUS_COMPLETED,
            'completed_at' => now(),
        ]);

        return redirect()->route('reviews.index')->with('success', 'Review submitted successfully.');
    }

    /**
     * Editor: list all submissions for management.
     */
    public function editorSubmissions(Request $request): View
    {
        $submissions = Submission::where('assigned_editor_id', $request->user()->id)
            ->with(['author', 'reviews.reviewer', 'reviewAssignments.reviewer'])
            ->latest()
            ->paginate(15);

        return view('reviews.editor-submissions', compact('submissions'));
    }

    /**
     * Editor: show submission and make decision.
     */
 public function editorShow(Submission $submission): View
{
    if ($submission->assigned_editor_id !== auth()->id()) {
        abort(403, 'You do not have access to this submission.');
    }

    $submission->load(['author', 'reviews.reviewer', 'reviewAssignments.reviewer']);

    $researchField = $submission->research_field;

    $matchedReviewers = \App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'reviewer'))
        ->whereHas('editorExpertise', fn($q) => $q->where('field_name', $researchField))
        ->withCount(['reviewAssignments as active_reviews_count' => fn($q) =>
            $q->whereNotIn('status', ['completed', 'declined'])
        ])
        ->get();

    $otherReviewers = \App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'reviewer'))
        ->whereNotIn('id', $matchedReviewers->pluck('id'))
        ->withCount(['reviewAssignments as active_reviews_count' => fn($q) =>
            $q->whereNotIn('status', ['completed', 'declined'])
        ])
        ->get();

    return view('reviews.editor-show', compact('submission', 'matchedReviewers', 'otherReviewers'));
}

    /**
     * Editor: show initial screening form.
     */
    public function editorInitialScreening(Submission $submission): View
    {
        if ($submission->assigned_editor_id !== auth()->id()) {
            abort(403, 'You do not have access to this submission.');
        }

        return view('reviews.editor-initial-screening', compact('submission'));
    }

    /**
     * Editor: store initial screening decision.
     */
   public function storeInitialScreening(Request $request, Submission $submission): RedirectResponse
{
    if ($submission->assigned_editor_id !== $request->user()->id) {
        abort(403);
    }

    $validated = $request->validate([
        'screening_status' => 'required|in:passed,failed,revision',
        'comments'         => 'required|string|max:2000',
       'revision_type' => 'nullable|required_if:screening_status,revision|in:minor,major',
    ]);

    if ($validated['screening_status'] === 'revision') {
        \App\Models\RevisionRequest::create([
            'submission_id'        => $submission->id,
            'requested_by_user_id' => $request->user()->id,
            'revision_type'        => $validated['revision_type'],
            'reason'               => $validated['comments'],
            'requested_at'         => now(),
        ]);

        $submission->update([
            'status'                     => Submission::STATUS_REVISIONS_REQUESTED,
            'initial_screening_status'   => 'failed',
            'initial_screening_comments' => $validated['comments'],
            'initial_screening_by'       => auth()->id(),
            'initial_screening_at'       => now(),
        ]);

        \App\Models\Notification::create([
            'user_id'         => $submission->author_id,
            'title'           => '🔄 Revision Requested — Initial Screening',
            'message'         => "The editor has reviewed your manuscript \"{$submission->title}\" and is requesting a " . $validated['revision_type'] . " revision before it can proceed.\n\nReason: {$validated['comments']}",
            'type'            => 'warning',
            'notifiable_id'   => $submission->id,
            'notifiable_type' => Submission::class,
        ]);

        return redirect()->route('editor.submission.show', $submission)
            ->with('success', 'Revision requested. Author has been notified.');
    }

    $isPassed = $validated['screening_status'] === 'passed';

    $submission->update([
        'initial_screening_status'   => $validated['screening_status'],
        'initial_screening_comments' => $validated['comments'],
        'initial_screening_by'       => auth()->id(),
        'initial_screening_at'       => now(),
    ]);

    \App\Models\Notification::create([
        'user_id'         => $submission->author_id,
        'title'           => $isPassed ? '✅ Submission Passed Initial Screening' : '❌ Submission Failed Initial Screening',
        'message'         => $isPassed
            ? "Your manuscript \"{$submission->title}\" has passed the initial screening.\n\nComments: {$validated['comments']}"
            : "Your manuscript \"{$submission->title}\" did not pass the initial screening.\n\nComments: {$validated['comments']}",
        'type'            => $isPassed ? 'success' : 'danger',
        'notifiable_id'   => $submission->id,
        'notifiable_type' => Submission::class,
    ]);

    return redirect()->route('editor.submission.show', $submission)
        ->with('success', $isPassed ? 'Passed. Author notified.' : 'Failed. Author notified.');
}

    /**
     * Editor: assign reviewer to submission.
     */
    public function assignReviewer(Request $request, Submission $submission): RedirectResponse
    {
        if ($submission->assigned_editor_id !== $request->user()->id) {
            abort(403, 'You do not have access to this submission.');
        }

        // Check if initial screening has passed
        if (!$submission->hasPassedInitialScreening()) {
            return back()->withErrors('This manuscript must pass the initial screening before assigning a reviewer.');
        }

        $validated = $request->validate([
            'reviewer_id' => ['required', 'exists:users,id'],
            'due_at' => ['nullable', 'date'],
        ]);

        $reviewerId = $validated['reviewer_id'];
        $exists = ReviewAssignment::where('submission_id', $submission->id)
            ->where('reviewer_id', $reviewerId)
            ->exists();
        if ($exists) {
            return back()->with('error', 'This reviewer is already assigned.');
        }

        ReviewAssignment::create([
            'submission_id' => $submission->id,
            'reviewer_id' => $reviewerId,
            'assigned_by' => $request->user()->id,
            'due_at' => $validated['due_at'] ?? null,
        ]);

        \App\Models\Notification::create([
            'user_id'         => $reviewerId,
            'title'           => '📋 New Review Assignment',
            'message'         => "You have been assigned to review the manuscript \"{$submission->title}\". Please log in to view and submit your review.",
            'type'            => 'info',
            'notifiable_id'   => $submission->id,
            'notifiable_type' => \App\Models\Submission::class,
        ]);

        $submission->update(['status' => Submission::STATUS_UNDER_REVIEW]);

        return back()->with('success', 'Reviewer assigned.');

        $submission->update(['status' => Submission::STATUS_UNDER_REVIEW]);

        return back()->with('success', 'Reviewer assigned.');
    }

/**
     * Editor: make decision on submission.
     */
    public function editorDecision(Request $request, Submission $submission): RedirectResponse
    {
        if ($submission->assigned_editor_id !== $request->user()->id) {
            abort(403, 'You do not have access to this submission.');
        }

        $validated = $request->validate([
            'status'          => ['required', 'in:accepted,rejected,revisions_requested'],
            'editor_notes'    => ['nullable', 'string'],
            'revision_type'   => ['nullable', 'required_if:status,revisions_requested', 'in:minor,major'],
            'revision_reason' => ['nullable', 'required_if:status,revisions_requested', 'string'],
        ]);

        $submission->update([
            'status'             => $validated['status'],
            'editor_id'          => $request->user()->id,
            'editor_decision_at' => now(),
            'editor_notes'       => $validated['editor_notes'] ?? null,
        ]);

        if ($validated['status'] === Submission::STATUS_REVISIONS_REQUESTED) {
            RevisionRequest::create([
                'submission_id'        => $submission->id,
                'requested_by_user_id' => $request->user()->id,
                'revision_type'        => $validated['revision_type'],
                'reason'               => $validated['revision_reason'],
                'requested_at'         => now(),
            ]);

            return redirect()->route('editor.submissions')
                ->with('success', 'Revision request sent to author.');
        }

        return redirect()->route('editor.submissions')->with('success', 'Decision recorded.');
    }

    /**
     * Admin: list all submissions for management.
     */
    public function adminSubmissions(Request $request): View
    {
        $submissions = Submission::with(['author', 'reviews.reviewer', 'reviewAssignments.reviewer'])
            ->latest()
            ->paginate(15);

        return view('reviews.admin-submissions', compact('submissions'));
    }

    /**
     * Admin: show submission details.
     */
    public function adminShow(Submission $submission): View
    {
        $submission->load(['author', 'reviews.reviewer', 'reviewAssignments.reviewer']);
        return view('reviews.admin-show', compact('submission'));
    }

    /**
     * Download submission file (reviewer or editor access).
     */
    public function downloadFile(Submission $submission): StreamedResponse
    {
        $user = request()->user();

        if ($user->isEditor() || $user->isEditorInChief()) {
            return $this->serializeFile($submission);
        }

        $isAssignedReviewer = ReviewAssignment::where('submission_id', $submission->id)
            ->where('reviewer_id', $user->id)
            ->exists();

        if ($isAssignedReviewer) {
            return $this->serializeFile($submission);
        }

        if ($user->isAdmin()) {
            return $this->serializeFile($submission);
        }

        abort(403);
    }

    /**
     * Reviewer: show pending reviewer assignments table.
     */
    public function pendingReviewerAssignments(): View
    {
        $assignments = ReviewAssignment::where('reviewer_id', auth()->id())
            ->whereIn('status', ['pending', 'agreed'])
            ->with(['submission.author', 'reviewer', 'editor'])
            ->latest()
            ->paginate(10);

        return view('reviewer.pending-reviewer-assignments', compact('assignments'));
    }

    /**
     * Helper method to download file.
     */
    private function serializeFile(Submission $submission): StreamedResponse
    {
        if (!$submission->file_path || !Storage::disk('local')->exists($submission->file_path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('local')->download(
            $submission->file_path,
            $submission->file_name
        );
    }

    /**
 * Editor: request revision from author.
 */
public function requestRevision(Request $request, Submission $submission): RedirectResponse
{
    if ($submission->assigned_editor_id !== $request->user()->id) {
        abort(403);
    }

    $validated = $request->validate([
        'revision_type'   => ['required', 'in:minor,major'],
        'revision_reason' => ['required', 'string', 'max:2000'],
    ]);

    $revisionRequest = RevisionRequest::create([
        'submission_id'        => $submission->id,
        'requested_by_user_id' => $request->user()->id,
        'revision_type'        => $validated['revision_type'],
        'reason'               => $validated['revision_reason'],
        'requested_at'         => now(),
    ]);

    $submission->update([
        'status'             => Submission::STATUS_REVISIONS_REQUESTED,
        'editor_id'          => $request->user()->id,
        'editor_decision_at' => now(),
    ]);

    \App\Models\Notification::create([
        'user_id'         => $submission->author_id,
        'title'           => '🔄 Revision Requested',
        'message'         => "The editor has requested a " . $validated['revision_type'] . " revision for your manuscript \"{$submission->title}\".\n\nReason: {$validated['revision_reason']}",
        'type'            => 'warning',
        'notifiable_id'   => $submission->id,
        'notifiable_type' => Submission::class,
    ]);

    return back()->with('success', 'Revision request sent to author.');
}

/**
 * Reviewer: request revision from author.
 */
public function reviewerRequestRevision(Request $request, Submission $submission): RedirectResponse
{
    $isAssigned = \App\Models\ReviewAssignment::where('submission_id', $submission->id)
        ->where('reviewer_id', $request->user()->id)
        ->exists();

    if (!$isAssigned) {
        abort(403);
    }

    $validated = $request->validate([
        'revision_type'   => ['required', 'in:minor,major'],
        'revision_reason' => ['required', 'string', 'max:2000'],
    ]);

    $revisionRequest = RevisionRequest::create([
        'submission_id'        => $submission->id,
        'requested_by_user_id' => $request->user()->id,
        'revision_type'        => $validated['revision_type'],
        'reason'               => $validated['revision_reason'],
        'requested_at'         => now(),
    ]);

    \App\Models\Notification::create([
        'user_id'         => $submission->author_id,
        'title'           => '🔄 Revision Requested by Reviewer',
        'message'         => "A reviewer has requested a " . $validated['revision_type'] . " revision for your manuscript \"{$submission->title}\".\n\nReason: {$validated['revision_reason']}",
        'type'            => 'warning',
        'notifiable_id'   => $submission->id,
        'notifiable_type' => Submission::class,
    ]);

    return back()->with('success', 'Revision request sent to author.');
}
}
