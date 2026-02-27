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
     * NEW WORKFLOW: Revised manuscripts go to assigned editor first for review,
     * then editor decides whether to forward to original reviewers or make final decision
     */
    public static function processRevisionSubmission(
        RevisionRequest $revisionRequest,
        string $filePath,
        string $revisionNotes
    ): void {
        DB::transaction(function () use ($revisionRequest, $filePath, $revisionNotes) {
            try {
                $submission = $revisionRequest->submission;

                // Preserve original file info and update only the file path
                $updateData = [
                    'file_path' => $filePath,
                    // Keep the same file_name (don't use basename hash)
                    'status' => Submission::STATUS_REVISION_UNDER_REVIEW,
                ];

                if (!$submission->original_file_path) {
                    $updateData['original_file_path'] = $submission->file_path;
                    $updateData['original_file_name'] = $submission->file_name;
                }

                $submission->update($updateData);

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

                // For review-stage revisions: notify editor that revision is awaiting their review
                // DO NOT automatically assign reviewers - editor will decide after reviewing
                self::notifyEditorOfSubmittedRevisionAwaitingReview($submission, $revisionRequest);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Error processing revision submission', [
                    'revision_request_id' => $revisionRequest->id,
                    'submission_id' => $revisionRequest->submission_id,
                    'error' => $e->getMessage(),
                ]);
                throw $e;
            }
        });
    }

    /**
     * Assign original reviewers to revision review
     * Called by editor when they decide to forward revision to original reviewers
     * 
     * @throws \RuntimeException if no reviewers found
     */
    public static function assignOriginalReviewersForRevision(RevisionRequest $revisionRequest): void
    {
        try {
            $submission = $revisionRequest->submission;

            $originalReviewers = $submission->reviewAssignments()
                ->where('status', 'completed')
                ->pluck('reviewer_id')
                ->unique();

            if ($originalReviewers->isEmpty()) {
                throw new \RuntimeException('No original reviewers found for this submission.');
            }

            foreach ($originalReviewers as $reviewerId) {
                RevisionReview::create([
                    'revision_request_id' => $revisionRequest->id,
                    'reviewer_id' => $reviewerId,
                    'status' => RevisionReview::STATUS_ASSIGNED,
                    'assigned_at' => now(),
                    'due_at' => now()->addDays(14),
                ]);
            }

            // Notify reviewers after successful assignment
            self::notifyReviewersOfRevision($submission, $revisionRequest);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error assigning original reviewers for revision', [
                'revision_request_id' => $revisionRequest->id,
                'submission_id' => $revisionRequest->submission_id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
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
        try {
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
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error notifying author of revision request', [
                'submission_id' => $submission->id,
                'error' => $e->getMessage(),
            ]);
            // Don't throw - notification failure shouldn't block the process
        }
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
     * Notify editor that author submitted revision (awaiting editor review)
     * NEW WORKFLOW: Editor must review revision first before deciding to forward to reviewers
     */
    private static function notifyEditorOfSubmittedRevisionAwaitingReview(Submission $submission, RevisionRequest $revisionRequest): void
    {
        try {
            if (!$submission->assigned_editor_id) {
                \Illuminate\Support\Facades\Log::warning('No assigned editor for submission', [
                    'submission_id' => $submission->id,
                ]);
                return;
            }

            \App\Models\Notification::create([
                'user_id' => $submission->assigned_editor_id,
                'title' => '📄 Revised Manuscript Submitted - Awaiting Your Review',
                'message' => "Author has submitted revision for \"{$submission->title}\".\n\nAuthor's Notes: {$revisionRequest->revision_notes}\n\nPlease review the revision and decide whether to forward it to original reviewers or make a final decision.",
                'type' => 'info',
                'notifiable_id' => $submission->id,
                'notifiable_type' => Submission::class,
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error notifying editor of revision submission', [
                'submission_id' => $submission->id,
                'error' => $e->getMessage(),
            ]);
            // Don't throw - notification failure shouldn't block the process
        }
    }

    /**
     * Notify reviewers of revision to review
     * Called automatically when editor forwards revision to original reviewers
     */
    private static function notifyReviewersOfRevision(Submission $submission, RevisionRequest $revisionRequest): void
    {
        try {
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
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error notifying reviewers of revision', [
                'submission_id' => $submission->id,
                'error' => $e->getMessage(),
            ]);
            // Don't throw - notification failure shouldn't block the process
        }
    }
}
