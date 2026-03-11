<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ReviewAssignment;
use App\Models\Submission;
use App\Models\RevisionRequest;
use App\Models\RevisionReview;
use App\Models\LayoutEditorAssignment;
use App\Models\User;
use App\Services\RevisionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

        // Load existing draft if available
        $existingReview = Review::where('submission_id', $submission->id)
            ->where('reviewer_id', request()->user()->id)
            ->where('status', Review::STATUS_DRAFT)
            ->first();

        return view('reviews.create', compact('assignment', 'submission', 'existingReview'));
    }

    /**
     * Show revised submission and form to submit revision review (reviewer).
     */
    public function revisionCreate(RevisionRequest $revisionRequest): View|RedirectResponse
    {
        $reviewAssignment = $revisionRequest->submission->reviewAssignments()
            ->where('reviewer_id', request()->user()->id)
            ->first();

        if (!$reviewAssignment) {
            abort(403, 'You are not assigned to review this submission.');
        }

        $revisionRequest->load('submission.author');
        $submission = $revisionRequest->submission;

        return view('reviews.create', compact('revisionRequest', 'submission'));
    }

    /**
     * Store review (reviewer).
     */
    public function store(Request $request): RedirectResponse
    {
        // Check which button was clicked
        $isSaveDraft = $request->has('action') && $request->input('action') === 'save_draft';

        // Make recommendation optional when saving as draft
        $rules = [
            'review_assignment_id' => ['required', 'exists:review_assignments,id'],
            'comments_for_author' => ['nullable', 'string'],
            'comments_for_editor' => ['nullable', 'string'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];

        // Recommendation is required only when submitting
        if (!$isSaveDraft) {
            $rules['recommendation'] = ['required', 'in:accept,minor_revisions,major_revisions,reject'];
        } else {
            $rules['recommendation'] = ['nullable', 'in:accept,minor_revisions,major_revisions,reject'];
        }

        $validated = $request->validate($rules);

        $assignment = ReviewAssignment::findOrFail($validated['review_assignment_id']);
        if ($assignment->reviewer_id !== $request->user()->id) {
            abort(403);
        }
        if ($assignment->status === ReviewAssignment::STATUS_COMPLETED) {
            return redirect()->route('reviews.index')->with('error', 'Review already submitted.');
        }

        // Check if a draft already exists
        $review = Review::where('submission_id', $assignment->submission_id)
            ->where('reviewer_id', $request->user()->id)
            ->where('status', Review::STATUS_DRAFT)
            ->first();

        $status = $isSaveDraft ? Review::STATUS_DRAFT : Review::STATUS_SUBMITTED;
        $submittedAt = !$isSaveDraft ? now() : null;

        if ($review) {
            // Update existing draft
            $review->update([
                'recommendation' => $validated['recommendation'] ?? null,
                'comments_for_author' => $validated['comments_for_author'] ?? null,
                'comments_for_editor' => $validated['comments_for_editor'] ?? null,
                'rating' => $validated['rating'] ?? null,
                'status' => $status,
                'submitted_at' => $submittedAt,
            ]);
        } else {
            // Create new review/draft
            $review = Review::create([
                'submission_id' => $assignment->submission_id,
                'reviewer_id' => $request->user()->id,
                'review_assignment_id' => $assignment->id,
                'recommendation' => $validated['recommendation'] ?? null,
                'comments_for_author' => $validated['comments_for_author'] ?? null,
                'comments_for_editor' => $validated['comments_for_editor'] ?? null,
                'rating' => $validated['rating'] ?? null,
                'status' => $status,
                'submitted_at' => $submittedAt,
            ]);
        }

        // Only update assignment status if actually submitting
        if (!$isSaveDraft) {
            $assignment->update([
                'status' => ReviewAssignment::STATUS_COMPLETED,
                'completed_at' => now(),
            ]);

            // Notify editor that reviewer has completed their review
            \App\Models\Notification::create([
                'user_id'         => $assignment->submission->assigned_editor_id,
                'role'            => 'editor',
                'title'           => '✓ Review Submitted - Action Required',
                'message'         => "Reviewer has completed their review for \"{$assignment->submission->title}\". Recommendation: " . ucfirst(str_replace('_', ' ', $validated['recommendation'])) . ". Please review and make your decision.",
                'type'            => 'info',
                'notifiable_id'   => $assignment->submission_id,
                'notifiable_type' => Submission::class,
            ]);

            return redirect()->route('reviews.index')->with('success', 'Review submitted successfully.');
        } else {
            return redirect()->route('reviews.index')->with('success', 'Review saved as draft. You can continue editing it later.');
        }
    }

    /**
     * Editor: list all submissions for management.
     */
    public function editorSubmissions(Request $request): View
    {
        $submissions = Submission::where('assigned_editor_id', $request->user()->id)
            ->with([
                'author',
                'reviews.reviewer',
                'reviewAssignments.reviewer',
                'revisionRequests.revisionReviews.reviewer',
            ])
            ->latest()
            ->paginate(15);

        return view('reviews.editor-submissions', compact('submissions'));
    }

    /**
     * Editor: show submission and make decision.
     */
    public function editorShow(Submission $submission): View
    {
        if ($submission->assigned_editor_id !== request()->user()->id) {
            abort(403, 'You do not have access to this submission.');
        }

        $submission->load([
            'author',
            'reviews.reviewer',
            'reviewAssignments.reviewer',
            'revisionRequests.revisionReviews.reviewer',
        ]);

        $researchField = $submission->research_field;

        // Check if original file exists
        $originalFileExists = $submission->original_file_path &&
                             \Illuminate\Support\Facades\Storage::disk('local')->exists($submission->original_file_path);

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

        // Get IDs of reviewers already assigned to this submission (for display purposes)
        $assignedReviewerIds = $submission->reviewAssignments()
            ->pluck('reviewer_id')
            ->toArray();

        // Get IDs of reviewers with declined assignments to this submission
        $declinedReviewerIds = $submission->reviewAssignments()
            ->where('status', ReviewAssignment::STATUS_DECLINED)
            ->pluck('reviewer_id')
            ->toArray();

        // Get decline reasons mapped by reviewer ID
        $declineReasons = $submission->reviewAssignments()
            ->where('status', ReviewAssignment::STATUS_DECLINED)
            ->pluck('decline_reason', 'reviewer_id')
            ->toArray();

        // Get all layout editors for selection
       $managingEditors = User::whereHas('roles', fn($q) => $q->where('name', 'managing-editor'))->get();

return view('reviews.editor-show', compact('submission', 'matchedReviewers', 'otherReviewers', 'managingEditors', 'assignedReviewerIds', 'declinedReviewerIds', 'declineReasons', 'originalFileExists'));
    }

    /**
     * Editor: show initial screening form.
     */
    public function editorInitialScreening(Submission $submission): View
    {
        if ($submission->assigned_editor_id !== request()->user()->id) {
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
            'revision_type'    => 'required_if:screening_status,revision|in:minor,major',
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
                'initial_screening_by'       => $request->user()->id,
                'initial_screening_at'       => now(),
            ]);

            \App\Models\Notification::create([
                'user_id'         => $submission->author_id,
                'role'            => 'author',
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
            'initial_screening_by'       => $request->user()->id,
            'initial_screening_at'       => now(),
        ]);

        \App\Models\Notification::create([
            'user_id'         => $submission->author_id,
            'role'            => 'author',
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
     * Handles both regular manuscript reviews AND revised manuscript reviews
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
            'reviewer_ids' => ['required', 'array', 'min:1'],
            'reviewer_ids.*' => ['exists:users,id'],
            'due_at' => ['nullable', 'date'],
        ]);

        $reviewerIds = $validated['reviewer_ids'];
        $dueAt = $validated['due_at'] ?? null;

        // Check if this is a revised manuscript review
        $isRevisionReview = $submission->status === Submission::STATUS_REVISION_UNDER_REVIEW;

        if ($isRevisionReview) {
            // Handle revised manuscript review assignment
            $latestRevision = $submission->revisionRequests()->latest()->first();

            if (!$latestRevision) {
                return back()->withErrors('No revision request found for this submission.');
            }

            $assignedCount = 0;
            $skippedCount = 0;

            foreach ($reviewerIds as $reviewerId) {
                // Check if already assigned to this revision (but allow reassigning if declined)
                $existingReview = RevisionReview::where('revision_request_id', $latestRevision->id)
                    ->where('reviewer_id', $reviewerId)
                    ->whereNotIn('status', [RevisionReview::STATUS_DECLINED])
                    ->first();

                if ($existingReview) {
                    $skippedCount++;
                    continue;
                }

                // If they previously declined, update that assignment; otherwise create new
                $revisionReview = RevisionReview::where('revision_request_id', $latestRevision->id)
                    ->where('reviewer_id', $reviewerId)
                    ->where('status', RevisionReview::STATUS_DECLINED)
                    ->first();

                if ($revisionReview) {
                    // Reassigning a reviewer who previously declined
                    $revisionReview->update([
                        'status' => RevisionReview::STATUS_ASSIGNED,
                        'assigned_at' => now(),
                        'due_at' => $dueAt ?? now()->addDays(14),
                    ]);
                } else {
                    // Creating new assignment
                    $revisionReview = RevisionReview::create([
                        'revision_request_id' => $latestRevision->id,
                        'reviewer_id' => $reviewerId,
                        'status' => RevisionReview::STATUS_ASSIGNED,
                        'assigned_at' => now(),
                        'due_at' => $dueAt ?? now()->addDays(14),
                    ]);
                }

                // Notify reviewer about revised manuscript
                \App\Models\Notification::create([
                    'user_id' => $reviewerId,
                    'role' => 'reviewer',
                    'title' => '🔄 Revised Manuscript Ready for Re-Review',
                    'message' => "A revised manuscript for \"{$submission->title}\" is ready for your re-review. Please log in to view and submit your feedback.",
                    'type' => 'info',
                    'notifiable_id' => $submission->id,
                    'notifiable_type' => \App\Models\Submission::class,
                ]);

                $assignedCount++;
            }

            // Do NOT change submission status for revised manuscripts
            $message = "Assigned reviewers ($assignedCount) to revised manuscript";
            if ($skippedCount > 0) {
                $message .= ". Skipped already-assigned reviewers ($skippedCount).";
            }

            return back()->with('success', $message);

        } else {
            // Handle regular manuscript review assignment
            $assignedCount = 0;
            $skippedCount = 0;

            foreach ($reviewerIds as $reviewerId) {
                // Check if already assigned (but allow reassigning if declined)
                $existingAssignment = ReviewAssignment::where('submission_id', $submission->id)
                    ->where('reviewer_id', $reviewerId)
                    ->whereNotIn('status', [ReviewAssignment::STATUS_DECLINED])
                    ->first();

                if ($existingAssignment) {
                    $skippedCount++;
                    continue;
                }

                // If they previously declined, update that assignment; otherwise create new
                $assignment = ReviewAssignment::where('submission_id', $submission->id)
                    ->where('reviewer_id', $reviewerId)
                    ->where('status', ReviewAssignment::STATUS_DECLINED)
                    ->first();

                if ($assignment) {
                    // Reassigning a reviewer who previously declined
                    $assignment->update([
                        'status' => ReviewAssignment::STATUS_PENDING,
                        'assigned_by' => $request->user()->id,
                        'due_at' => $dueAt,
                    ]);
                } else {
                    // Creating new assignment
                    $assignment = ReviewAssignment::create([
                        'submission_id' => $submission->id,
                        'reviewer_id' => $reviewerId,
                        'assigned_by' => $request->user()->id,
                        'status' => ReviewAssignment::STATUS_PENDING,
                        'due_at' => $dueAt,
                    ]);
                }

                \App\Models\Notification::create([
                    'user_id'         => $reviewerId,
                    'role'            => 'reviewer',
                    'title'           => '📋 New Review Assignment',
                    'message'         => "You have been assigned to review the manuscript \"{$submission->title}\". Please accept or decline the assigned manuscript.",
                    'type'            => 'info',
                    'notifiable_id'   => $submission->id,
                    'notifiable_type' => \App\Models\Submission::class,
                ]);

                $assignedCount++;
            }

            $submission->update(['status' => Submission::STATUS_UNDER_REVIEW]);

            if ($skippedCount > 0) {
                return back()->with('success', "Assigned reviewers ($assignedCount). Skipped already-assigned reviewers ($skippedCount).");
            }

            return back()->with('success', "Assigned $assignedCount reviewer(s). Reviewers have been notified.");
        }
    }

    /**
     * Editor: make decision on submission.
     */
    public function editorDecision(Request $request, Submission $submission): RedirectResponse
    {
        if ($submission->assigned_editor_id !== $request->user()->id) {
            abort(403, 'You do not have access to this submission.');
        }

        // Check which button was clicked
        $isSaveDraft = $request->has('action') && $request->input('action') === 'save_draft';

        // Make status optional when saving as draft
        $rules = [
            'editor_notes' => ['nullable', 'string'],
        ];

        if (!$isSaveDraft) {
            $rules['status'] = ['required', 'in:accepted,rejected,revisions_requested'];
            $rules['revision_type'] = ['required_if:status,revisions_requested', 'in:minor,major'];
            $rules['revision_reason'] = ['required_if:status,revisions_requested', 'string'];
        } else {
            $rules['status'] = ['nullable', 'in:accepted,rejected,revisions_requested'];
            $rules['revision_type'] = ['nullable', 'in:minor,major'];
            $rules['revision_reason'] = ['nullable', 'string'];
        }

        $validated = $request->validate($rules);

        if ($isSaveDraft) {
            // Save as draft
            $submission->update([
                'editor_decision_draft' => $validated,
            ]);
            return redirect()->route('editor.submissions')
                ->with('success', 'Decision draft saved. You can continue editing it later.');
        }

        // Final submission
        $submission->update([
            'status' => $validated['status'],
            'editor_id' => $request->user()->id,
            'editor_decision_at' => now(),
            'editor_notes' => $validated['editor_notes'] ?? null,
            'editor_decision_draft' => null,
        ]);

        // Notify author of the editor's decision
        if ($validated['status'] === Submission::STATUS_ACCEPTED) {
            $statusText = 'Accepted';
            $type = 'success';
            $message = "Your manuscript \"{$submission->title}\" has been accepted and will proceed to layout editing.";
        } elseif ($validated['status'] === Submission::STATUS_REJECTED) {
            $statusText = 'Rejected';
            $type = 'danger';
            $message = "Your manuscript \"{$submission->title}\" has been rejected. Please review the editor's notes for feedback.";
        } else {
            $statusText = 'Revisions Requested';
            $type = 'warning';
            $message = "The editor has requested revisions to your manuscript \"{$submission->title}\". Please review the revision requirements and resubmit.";
        }

        \App\Models\Notification::create([
            'user_id'         => $submission->author_id,
            'role'            => 'author',
            'title'           => "✅ Editor Decision: {$statusText}",
            'message'         => $message,
            'type'            => $type,
            'notifiable_id'   => $submission->id,
            'notifiable_type' => Submission::class,
        ]);

        if ($validated['status'] === Submission::STATUS_REVISIONS_REQUESTED) {
            RevisionRequest::create([
                'submission_id' => $submission->id,
                'requested_by_user_id' => $request->user()->id,
                'revision_type' => $validated['revision_type'],
                'reason' => $validated['revision_reason'],
                'requested_at' => now(),
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
    public function downloadFile(Submission $submission)
    {
        $user = request()->user();

        if ($user->isEditor() || $user->isEditorInChief() || $user->hasRole('managing-editor')) {
            return $this->serializeFile($submission->file_path, $submission->file_name);
        }

        $isAssignedReviewer = ReviewAssignment::where('submission_id', $submission->id)
            ->where('reviewer_id', $user->id)
            ->exists();

        if ($isAssignedReviewer) {
            return $this->serializeFile($submission->file_path, $submission->file_name);
        }

        if ($user->isAdmin()) {
            return $this->serializeFile($submission->file_path, $submission->file_name);
        }

        abort(403);
    }

    /**
     * Download original submission file (before any revisions).
     */
    public function downloadOriginalFile(Submission $submission)
    {
        $user = request()->user();

        if ($user->isEditor() || $user->isEditorInChief()) {
            return $this->serializeFile($submission->original_file_path ?? $submission->file_path, $submission->original_file_name ?? $submission->file_name);
        }

        $isAssignedReviewer = ReviewAssignment::where('submission_id', $submission->id)
            ->where('reviewer_id', $user->id)
            ->exists();

        if ($isAssignedReviewer) {
            return $this->serializeFile($submission->original_file_path ?? $submission->file_path, $submission->original_file_name ?? $submission->file_name);
        }

        if ($user->isAdmin()) {
            return $this->serializeFile($submission->original_file_path ?? $submission->file_path, $submission->original_file_name ?? $submission->file_name);
        }

        abort(403);
    }

    /**
     * Reviewer: show pending reviewer assignments table.
     */
    public function pendingReviewerAssignments(): View
    {
        $assignments = ReviewAssignment::where('reviewer_id', request()->user()->id)
            ->whereIn('status', ['pending', 'agreed'])
            ->with(['submission.author', 'reviewer', 'editor'])
            ->latest()
            ->paginate(10);

        return view('reviewer.pending-reviewer-assignments', compact('assignments'));
    }

    /**
     * Helper method to download file.
     */
    private function serializeFile($filePath, $fileName)
    {
        if (!$filePath || !Storage::disk('local')->exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download(
            Storage::disk('local')->path($filePath),
            $fileName
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

        RevisionService::createRevisionRequest(
            $submission,
            $request->user(),
            $validated['revision_type'],
            $validated['revision_reason'],
            'review'
        );

        return back()->with('success', 'Revision request sent to author.');
    }

    /**
     * Reviewer: show form to submit review on revised manuscript.
     */
    public function createRevisionReview(RevisionReview $revisionReview): View|RedirectResponse
    {
        if ($revisionReview->reviewer_id !== request()->user()->id) {
            abort(403);
        }
        if ($revisionReview->status === RevisionReview::STATUS_COMPLETED) {
            return redirect()->route('reviews.index')->with('info', 'You have already submitted this revision review.');
        }

        $revisionReview->load('revisionRequest.submission.author');
        $submission = $revisionReview->revisionRequest->submission;

        return view('reviews.revision-review-create', compact('revisionReview', 'submission'));
    }

    /**
     * Reviewer: store review on revised manuscript.
     */
    public function storeRevisionReview(Request $request): RedirectResponse
    {
        // Check which button was clicked
        $isSaveDraft = $request->has('action') && $request->input('action') === 'save_draft';

        // Make recommendation optional when saving as draft
        $rules = [
            'revision_review_id' => ['required', 'exists:revision_reviews,id'],
            'comments_for_author' => ['nullable', 'string'],
            'comments_for_editor' => ['nullable', 'string'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];

        // Recommendation is required only when submitting
        if (!$isSaveDraft) {
            $rules['recommendation'] = ['required', 'in:accept,minor_revisions,major_revisions,reject'];
        } else {
            $rules['recommendation'] = ['nullable', 'in:accept,minor_revisions,major_revisions,reject'];
        }

        $validated = $request->validate($rules);

        $revisionReview = RevisionReview::findOrFail($validated['revision_review_id']);
        if ($revisionReview->reviewer_id !== $request->user()->id) {
            abort(403);
        }
        if ($revisionReview->status === RevisionReview::STATUS_COMPLETED) {
            return redirect()->route('reviews.index')->with('error', 'Review already submitted.');
        }

        $submissionStatus = $isSaveDraft ? RevisionReview::SUBMISSION_STATUS_DRAFT : RevisionReview::SUBMISSION_STATUS_SUBMITTED;
        $completedAt = !$isSaveDraft ? now() : null;

        $updateData = [
            'recommendation' => $validated['recommendation'] ?? null,
            'comments_for_author' => $validated['comments_for_author'] ?? null,
            'comments_for_editor' => $validated['comments_for_editor'] ?? null,
            'rating' => $validated['rating'] ?? null,
            'submission_status' => $submissionStatus,
        ];

        // Only set completion status if actually submitting
        if (!$isSaveDraft) {
            $updateData['status'] = RevisionReview::STATUS_COMPLETED;
            $updateData['completed_at'] = now();
        }

        $revisionReview->update($updateData);

        // Only notify editor if actually submitting
        if (!$isSaveDraft) {
            $submission = $revisionReview->revisionRequest->submission;
            \App\Models\Notification::create([
                'user_id' => $submission->assigned_editor_id,
                'role' => 'editor',
                'title' => '✓ Revision Review Submitted',
                'message' => "Reviewer has completed re-review for revised manuscript \"{$submission->title}\". Recommendation: " . $validated['recommendation'],
                'type' => 'info',
                'notifiable_id' => $submission->id,
                'notifiable_type' => Submission::class,
            ]);

            return redirect()->route('reviews.index')->with('success', 'Revision review submitted successfully.');
        } else {
            return redirect()->route('reviews.index')->with('success', 'Revision review saved as draft. You can continue editing it later.');
        }
    }

    /**
     * Editor: forward revised manuscript to original reviewers
     * NEW WORKFLOW: Editor reviews revision first, then decides to forward to reviewers
     *
     * Route: POST /editor/submissions/{submission}/forward-revision-to-reviewers
     */
    public function forwardRevisionToReviewers(Request $request, Submission $submission): RedirectResponse
    {
        try {
            // Verify authorization
            if ($submission->assigned_editor_id !== $request->user()->id) {
                abort(403, 'You do not have access to this submission.');
            }

            // Verify submission is in correct status (awaiting editor review of revision)
            if ($submission->status !== Submission::STATUS_REVISION_UNDER_REVIEW) {
                return back()->withErrors('This submission is not awaiting your revision review.');
            }

            // Get the latest revision request
            $revision = $submission->revisionRequests()->latest()->first();
            if (!$revision || !$revision->revised_at) {
                return back()->withErrors('No revised manuscript found for this submission.');
            }

            // Check if reviewers have already been assigned
            if ($revision->revisionReviews()->exists()) {
                return back()->withErrors('Reviewers have already been assigned for this revision.');
            }

            // Assign original reviewers
            RevisionService::assignOriginalReviewersForRevision($revision);

            Log::info('Revised manuscript forwarded to reviewers', [
                'submission_id' => $submission->id,
                'revision_request_id' => $revision->id,
                'editor_id' => $request->user()->id,
            ]);

            return redirect()->route('editor.revision-reviews')
                ->with('success', 'Revised manuscript forwarded to original reviewers. They have been notified.');
        } catch (\RuntimeException $e) {
            Log::error('Error forwarding revision to reviewers', [
                'submission_id' => $submission->id,
                'error' => $e->getMessage(),
            ]);
            return back()->withErrors('Unable to forward to reviewers: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Unexpected error forwarding revision to reviewers', [
                'submission_id' => $submission->id,
                'error' => $e->getMessage(),
            ]);
            return back()->withErrors('An unexpected error occurred. Please try again.');
        }
    }

    /**
     * Editor: list pending revision reviews for submissions.
     */
    public function editorRevisionReviews(Request $request): View
    {
        $pendingSubmissions = Submission::where('assigned_editor_id', $request->user()->id)
            ->where('status', Submission::STATUS_REVISION_UNDER_REVIEW)
            ->with([
                'revisionRequests.revisionReviews.reviewer',
                'author',
            ])
            ->latest()
            ->paginate(15);

        $completedSubmissions = Submission::where('assigned_editor_id', $request->user()->id)
            ->whereIn('status', [Submission::STATUS_ACCEPTED, Submission::STATUS_REJECTED])
            ->where('editor_decision_at', '!=', null)
            ->with(['revisionRequests', 'author'])
            ->latest('editor_decision_at')
            ->take(10)
            ->get();

        return view('reviews.editor-revision-reviews', compact('pendingSubmissions', 'completedSubmissions'));
    }

    /**
     * Editor: make final decision after revision reviews.
     */
    public function editorRevisionDecision(Request $request, Submission $submission): RedirectResponse
    {
        Log::info('editorRevisionDecision called', [
            'submission_id' => $submission->id,
            'user_id' => $request->user()->id,
            'assigned_editor_id' => $submission->assigned_editor_id,
            'status' => $submission->status,
        ]);

        if ($submission->assigned_editor_id !== $request->user()->id) {
            abort(403, 'You do not have access to this submission.');
        }

        if ($submission->status !== Submission::STATUS_REVISION_UNDER_REVIEW) {
            return back()->withErrors('This submission is not awaiting your revision decision.');
        }

        // Check which button was clicked
        $isSaveDraft = $request->has('action') && $request->input('action') === 'save_draft';

        // Make decision optional when saving as draft
        $rules = [
            'editor_notes' => ['nullable', 'string'],
        ];

        if (!$isSaveDraft) {
            $rules['decision'] = ['required', 'in:accepted,rejected,revisions_requested'];
            $rules['revision_type'] = ['required_if:decision,revisions_requested', 'in:minor,major'];
            $rules['revision_reason'] = ['required_if:decision,revisions_requested', 'string'];
        } else {
            $rules['decision'] = ['nullable', 'in:accepted,rejected,revisions_requested'];
            $rules['revision_type'] = ['nullable', 'in:minor,major'];
            $rules['revision_reason'] = ['nullable', 'string'];
        }

        $validated = $request->validate($rules);

        Log::info('Validation passed', ['validated' => $validated]);

        if ($isSaveDraft) {
            $revision = $submission->revisionRequests()->latest()->first();
            if ($revision) {
                $revision->update([
                    'editor_decision_draft' => $validated,
                ]);
            }
            return redirect()->route('editor.submissions')
                ->with('success', 'Revision decision draft saved. You can continue editing it later.');
        }

        // Map decision to status constant
        $statusMap = [
            'accepted'             => Submission::STATUS_ACCEPTED,
            'rejected'             => Submission::STATUS_REJECTED,
            'revisions_requested'  => Submission::STATUS_REVISIONS_REQUESTED,
        ];

        $mappedStatus = $statusMap[$validated['decision']];
        Log::info('Status mapping', [
            'decision'     => $validated['decision'],
            'mappedStatus' => $mappedStatus,
        ]);

        // Clear draft when finalizing
        $revision = $submission->revisionRequests()->latest()->first();
        if ($revision) {
            $revision->update(['editor_decision_draft' => null]);
        }

        $updated = $submission->update([
            'status'                => $mappedStatus,
            'editor_id'             => $request->user()->id,
            'editor_decision_at'    => now(),
            'editor_notes'          => $validated['editor_notes'] ?? null,
            'editor_decision_draft' => null,
        ]);

        Log::info('Update result', [
            'updated'                => $updated,
            'submission_status_after' => $submission->fresh()->status,
        ]);

        if ($validated['decision'] === 'revisions_requested') {
            RevisionService::createRevisionRequest(
                $submission,
                $request->user(),
                $validated['revision_type'],
                $validated['revision_reason'],
                'review'
            );
        } else {
            $status = $validated['decision'] === 'accepted' ? 'Accepted' : 'Rejected';
            \App\Models\Notification::create([
                'user_id'         => $submission->author_id,
                'role'            => 'author',
                'title'           => "✓ Final Decision: {$status}",
                'message'         => "Your manuscript \"{$submission->title}\" has been {$status}.",
                'type'            => $validated['decision'] === 'accepted' ? 'success' : 'danger',
                'notifiable_id'   => $submission->id,
                'notifiable_type' => Submission::class,
            ]);
        }

        return redirect()->route('editor.submissions')
            ->with('success', 'Decision recorded and author notified.');
    }

    /**
     * Reviewer: accept review invitation.
     */
    public function acceptInvitation(ReviewAssignment $assignment): RedirectResponse
    {
        if ($assignment->reviewer_id !== request()->user()->id) {
            abort(403);
        }

        $assignment->update([
            'status' => ReviewAssignment::STATUS_ASSIGNED,
        ]);

        \App\Models\Notification::create([
            'user_id'         => $assignment->submission->assigned_editor_id,
            'role'            => 'editor',
            'title'           => '✓ Review Invitation Accepted',
            'message'         => 'Reviewer has accepted invitation to review "' . $assignment->submission->title . '"',
            'type'            => 'success',
            'notifiable_id'   => $assignment->submission_id,
            'notifiable_type' => Submission::class,
        ]);

        return redirect()->route('dashboard.reviewer')->with('success', 'Review invitation accepted.');
    }

    /**
     * Reviewer: decline review invitation.
     */
    public function declineInvitation(Request $request, ReviewAssignment $assignment): RedirectResponse
    {
        if ($assignment->reviewer_id !== request()->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'decline_reason' => 'nullable|string|max:1000',
        ]);

        $assignment->update([
            'status' => ReviewAssignment::STATUS_DECLINED,
            'decline_reason' => $validated['decline_reason'] ?? null,
        ]);

        \App\Models\Notification::create([
            'user_id'         => $assignment->submission->assigned_editor_id,
            'role'            => 'editor',
            'title'           => '✗ Review Invitation Declined',
            'message'         => 'Reviewer has declined invitation to review "' . $assignment->submission->title . '"',
            'type'            => 'warning',
            'notifiable_id'   => $assignment->submission_id,
            'notifiable_type' => Submission::class,
        ]);

        return redirect()->route('dashboard.reviewer')->with('info', 'Review invitation declined.');
    }

    /**
     * Reviewer: view peer reviews for a submission.
     * Reviews are only revealed once ALL assigned reviewers have submitted.
     * Reviewer identities are kept anonymous (Reviewer 1, Reviewer 2, etc.).
     *
     * Route: GET /reviews/submission/{submission}/peer-reviews
     * Name:  reviews.peer-reviews
     */
    public function peerReviews(Submission $submission): View|RedirectResponse
    {
        $user = request()->user();

        // Must be an assigned (non-declined) reviewer for this submission
        $myAssignment = ReviewAssignment::where('submission_id', $submission->id)
            ->where('reviewer_id', $user->id)
            ->whereNotIn('status', [ReviewAssignment::STATUS_DECLINED])
            ->first();

        if (!$myAssignment) {
            abort(403, 'You are not assigned to review this submission.');
        }

        $submission->load([
            'author',
            'reviewAssignments',
            'reviews.reviewer',
        ]);

        // All non-declined assignments (used for progress tracker)
        $assignments = $submission->reviewAssignments
            ->whereNotIn('status', [ReviewAssignment::STATUS_DECLINED])
            ->values();

        $totalAssigned = $assignments->count();

        // Only count fully submitted reviews (not drafts)
        $reviews = $submission->reviews
            ->where('status', Review::STATUS_SUBMITTED)
            ->values();

        $totalSubmitted = $reviews->count();

        // Gate: every assigned reviewer must have submitted before anyone sees peer reviews
        $allReviewsIn = $totalAssigned > 0 && $totalSubmitted >= $totalAssigned;

        // The current reviewer's own submitted review (always visible to them)
        $myReview = $submission->reviews
            ->where('reviewer_id', $user->id)
            ->where('status', Review::STATUS_SUBMITTED)
            ->first();

        return view('reviews.peer-reviews', compact(
            'submission',
            'assignments',
            'reviews',
            'totalAssigned',
            'totalSubmitted',
            'allReviewsIn',
            'myReview',
        ));
    }

    /**
     * Send an accepted paper to a layout editor
     */
    public function sendToLayoutEditor(Request $request, Submission $submission): RedirectResponse
    {
        if ($submission->assigned_editor_id !== $request->user()->id) {
            abort(403, 'You do not have access to this submission.');
        }

        // Only accepted papers can go to layout editor
        if ($submission->status !== Submission::STATUS_ACCEPTED) {
            return redirect()->back()->with('error', 'Only accepted papers can be sent to layout editor.');
        }

        $request->validate([
            'layout_editor_id' => ['required', 'exists:users,id'],
        ]);

        // Create layout editor assignment
        LayoutEditorAssignment::create([
            'submission_id' => $submission->id,
            'layout_editor_id' => $request->input('layout_editor_id'),
            'assigned_at' => now(),
            'status' => LayoutEditorAssignment::STATUS_PENDING,
        ]);

        // Update submission status
        $submission->update([
            'status' => Submission::STATUS_LAYOUT_EDITING,
        ]);

        return redirect()->route('editor.submission.show', $submission)
            ->with('success', 'Paper sent to layout editor successfully.');
    }

    /**
     * Send layout file to author for review
     */
    public function sendLayoutToAuthor(Request $request, Submission $submission): RedirectResponse
    {
        if ($submission->assigned_editor_id !== $request->user()->id) {
            abort(403, 'You do not have access to this submission.');
        }

        // Only papers in layout review status can be sent to author
        if ($submission->status !== Submission::STATUS_LAYOUT_REVIEW) {
            return redirect()->back()->with('error', 'Paper must be in layout review status.');
        }

        // Update submission status
        $submission->update([
            'status' => Submission::STATUS_AUTHOR_CONFIRMATION,
        ]);

        return redirect()->route('editor.submission.show', $submission)
            ->with('success', 'Layout file sent to author for confirmation.');
    }

    /**
     * Send an accepted paper to a Managing Editor
     * REPLACES sendToLayoutEditor — editor now sends to managing editor first
     */
    public function sendToManagingEditor(Request $request, Submission $submission): RedirectResponse
    {
        if ($submission->assigned_editor_id !== $request->user()->id) {
            abort(403, 'You do not have access to this submission.');
        }

        if ($submission->status !== Submission::STATUS_ACCEPTED) {
            return redirect()->back()->with('error', 'Only accepted papers can be sent to the managing editor.');
        }

        $request->validate([
            'managing_editor_id' => ['required', 'exists:users,id'],
        ]);

        // ─── GET LATEST REVISION FILE IF IT EXISTS ───
        $latestRevision = $submission->revisionRequests()
            ->whereNotNull('revised_file_path')
            ->orderBy('created_at', 'desc')
            ->first();

        $updateData = [
            'managing_editor_id'         => $request->input('managing_editor_id'),
            'managing_editor_assigned_at' => now(),
            'managing_editor_status'      => 'pending',
            'status'                      => Submission::STATUS_WITH_MANAGING_EDITOR,
        ];

        // If there's a latest revision, use its file instead of original
        if ($latestRevision && $latestRevision->revised_file_path) {
            $updateData['file_path'] = $latestRevision->revised_file_path;
            $updateData['file_name'] = $latestRevision->revised_file_name;
        }

        $submission->update($updateData);

        \App\Models\Notification::create([
            'user_id'         => $request->input('managing_editor_id'),
            'role'            => 'managing-editor',
            'title'           => '📄 New Manuscript Assignment',
            'message'         => "You have been assigned to manage the manuscript \"{$submission->title}\". Please issue the Copyright Transfer Form and assign a Layout Editor.",
            'type'            => 'info',
            'notifiable_id'   => $submission->id,
            'notifiable_type' => Submission::class,
        ]);

        return redirect()->route('editor.submission.show', $submission)
            ->with('success', 'Paper assigned to Managing Editor successfully.');
    }
}
