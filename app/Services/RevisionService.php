<?php

namespace App\Services;

use App\Models\Submission;
use App\Models\RevisionRequest;
use App\Models\RevisionReview;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RevisionService
{
    /**
     * Create a revision request (consolidated method)
     * Handles revision requests from: Chief Editor, Editor, Reviewer
     */
    public static function createRevisionRequest(
        Submission $submission,
        User $requestedBy,
        string $revisionType,
        string $reason,
        string $revisionStage = 'review'
    ): RevisionRequest {
        return DB::transaction(function () use ($submission, $requestedBy, $revisionType, $reason, $revisionStage) {
            
            // Determine assignee for next stage
            $assignee = null;
            if ($revisionStage === 'initial_screening') {
                $assignee = $submission->initialScreeningBy; // Back to chief editor
            } elseif ($revisionStage === 'review') {
                $assignee = $submission->assignedEditor; // Back to editor
            }

            // Create revision request
            $revisionRequest = RevisionRequest::create([
                'submission_id' => $submission->id,
                'requested_by_user_id' => $requestedBy->id,
                'revision_type' => $revisionType,
                'reason' => $reason,
                'requested_at' => now(),
                'revision_stage' => $revisionStage,
                'current_stage_assignee_id' => $assignee?->id,
            ]);

            // Update submission status
            $submission->update([
                'status' => Submission::STATUS_REVISIONS_REQUESTED,
                'editor_id' => $requestedBy->id,
                'editor_decision_at' => now(),
            ]);

            // Send notification to author
            self::notifyAuthorOfRevisionRequest($submission, $revisionType, $reason, $revisionStage);

            return $revisionRequest;
        });
    }

    /**
     * Process revised manuscript submission
     */
    public static function processRevisionSubmission(
        RevisionRequest $revisionRequest,
        string $filePath,
        string $revisionNotes
    ): void {
        DB::transaction(function () use ($revisionRequest, $filePath, $revisionNotes) {
            $submission = $revisionRequest->submission;

            // Update submission with revised file
            $submission->update([
                'file_path' => $filePath,
                'file_name' => basename($filePath),
                'status' => Submission::STATUS_REVISION_UNDER_REVIEW,
            ]);

            // Update revision request
            $revisionRequest->update([
                'revised_at' => now(),
                'revision_notes' => $revisionNotes,
            ]);

            // If initial screening revision, go back to chief editor only
            if ($revisionRequest->revision_stage === 'initial_screening') {
                self::notifyChiefEditorOfRevision($submission, $revisionRequest);
                return;
            }

            // For review-stage revisions, auto-assign original reviewers
            self::assignOriginalReviewersForRevision($revisionRequest);

            // Notify editor and reviewers
            self::notifyEditorOfSubmittedRevision($submission, $revisionRequest);
            self::notifyReviewersOfRevision($submission, $revisionRequest);
        });
    }

    /**
     * Auto-assign original reviewers to revision review
     */
    private static function assignOriginalReviewersForRevision(RevisionRequest $revisionRequest): void
    {
        $submission = $revisionRequest->submission;

        $originalReviewers = $submission->reviewAssignments()
            ->where('status', 'completed')
            ->pluck('reviewer_id')
            ->unique();

        foreach ($originalReviewers as $reviewerId) {
            RevisionReview::create([
                'revision_request_id' => $revisionRequest->id,
                'reviewer_id' => $reviewerId,
                'status' => RevisionReview::STATUS_ASSIGNED,
                'assigned_at' => now(),
                'due_at' => now()->addDays(14),
            ]);
        }
    }

    /**
     * Notify author of revision request
     */
    private static function notifyAuthorOfRevisionRequest(
        Submission $submission,
        string $revisionType,
        string $reason,
        string $revisionStage
    ): void {
        $stageLabel = [
            'initial_screening' => 'Initial Screening',
            'review' => 'Review',
            'post_review' => 'Post-Review',
        ][$revisionStage] ?? 'Review';

        \App\Models\Notification::create([
            'user_id' => $submission->author_id,
            'title' => '🔄 Revision Requested (' . ucfirst($stageLabel) . ')',
            'message' => "A {$revisionType} revision has been requested for your manuscript \"{$submission->title}\".\n\nReason: {$reason}",
            'type' => 'warning',
            'notifiable_id' => $submission->id,
            'notifiable_type' => Submission::class,
        ]);
    }

    /**
     * Notify chief editor that author submitted revision
     */
    private static function notifyChiefEditorOfRevision(Submission $submission, RevisionRequest $revisionRequest): void
    {
        $chefEditor = $submission->initialScreeningBy;
        if (!$chefEditor) return;

        \App\Models\Notification::create([
            'user_id' => $chefEditor->id,
            'title' => '📄 Revised Manuscript Submitted (Re-Screening Required)',
            'message' => "Author has submitted revision for \"{$submission->title}\" per your initial screening request.\n\nAuthor's Notes: {$revisionRequest->revision_notes}",
            'type' => 'info',
            'notifiable_id' => $submission->id,
            'notifiable_type' => Submission::class,
        ]);
    }

    /**
     * Notify editor that author submitted revision
     */
    private static function notifyEditorOfSubmittedRevision(Submission $submission, RevisionRequest $revisionRequest): void
    {
        \App\Models\Notification::create([
            'user_id' => $submission->assigned_editor_id,
            'title' => '📄 Revised Manuscript Submitted (Re-Review in Progress)',
            'message' => "Author has submitted revision for \"{$submission->title}\".\n\nAuthor's Notes: {$revisionRequest->revision_notes}\n\nReviewers have been notified to begin re-review.",
            'type' => 'info',
            'notifiable_id' => $submission->id,
            'notifiable_type' => Submission::class,
        ]);
    }

    /**
     * Notify reviewers of revision to review
     */
    private static function notifyReviewersOfRevision(Submission $submission, RevisionRequest $revisionRequest): void
    {
        $originalReviewers = $submission->reviewAssignments()
            ->where('status', 'completed')
            ->pluck('reviewer_id')
            ->unique();

        foreach ($originalReviewers as $reviewerId) {
            \App\Models\Notification::create([
                'user_id' => $reviewerId,
                'title' => '🔄 Revised Manuscript Ready for Re-Review',
                'message' => "A revised manuscript for \"{$submission->title}\" is ready for your re-review.\n\nAuthor's Revision Notes: {$revisionRequest->revision_notes}",
                'type' => 'info',
                'notifiable_id' => $submission->id,
                'notifiable_type' => Submission::class,
            ]);
        }
    }
}
