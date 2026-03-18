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

            $assignee = null;
            if ($revisionStage === 'initial_screening') {
                $assignee = $submission->initialScreeningBy;
            } elseif ($revisionStage === 'review') {
                $assignee = $submission->assignedEditor;
            }

            $revisionRequest = RevisionRequest::create([
                'submission_id' => $submission->id,
                'requested_by_user_id' => $requestedBy->id,
                'revision_type' => $revisionType,
                'reason' => $reason,
                'requested_at' => now(),
                'revision_stage' => $revisionStage,
                'current_stage_assignee_id' => $assignee?->id,
            ]);

            $submission->update([
                'status' => Submission::STATUS_REVISIONS_REQUESTED,
                'editor_id' => $requestedBy->id,
                'editor_decision_at' => now(),
            ]);

            self::notifyAuthorOfRevisionRequest($submission, $revisionType, $reason, $revisionStage);

            return $revisionRequest;
        });
    }

    /**
     * Process revised manuscript submission.
     * Saves the revised file path/name into the revision_requests row so
     * the sidebar can list and download each revision file independently.
     */
    public static function processRevisionSubmission(
        RevisionRequest $revisionRequest,
        string $filePath,
        string $revisionNotes,
        string $originalFileName = ''
    ): void {
        DB::transaction(function () use ($revisionRequest, $filePath, $revisionNotes, $originalFileName) {
            try {
                $submission = $revisionRequest->submission;

                // Preserve original file info
                $updateData = [
                    'file_path' => $filePath,
                    'status' => Submission::STATUS_REVISION_UNDER_REVIEW,
                ];

                if (!$submission->original_file_path) {
                    $updateData['original_file_path'] = $submission->file_path;
                    $updateData['original_file_name'] = $submission->file_name;
                }

                $submission->update($updateData);

                // ── SAVE file info on the revision request itself ─────────
                // Check if the filename already follows the MS format (MS-YYYY-###-R#)
                // If so, use it as-is; otherwise, add the R{n} prefix for backwards compatibility
                if (preg_match('/^MS-\d{4}-\d{3}-R\d+\./', $originalFileName)) {
                    // Already formatted with MS-YYYY-###-R# pattern
                    $displayName = $originalFileName;
                } else {
                    // Legacy format or no format - add R{n} prefix
                    $revisionNumber = RevisionRequest::where('submission_id', $submission->id)
                        ->whereNotNull('revised_file_path')
                        ->count() + 1;

                    $displayName = $originalFileName
                        ? 'R' . $revisionNumber . ' - ' . $originalFileName
                        : 'R' . $revisionNumber . ' - revision.pdf';
                }

                $revisionRequest->update([
                    'revised_at'        => now(),
                    'revision_notes'    => $revisionNotes,
                    'revised_file_path' => $filePath,
                    'revised_file_name' => $displayName,
                ]);
                // ─────────────────────────────────────────────────────────

                if ($revisionRequest->revision_stage === 'initial_screening') {
                    self::notifyChiefEditorOfRevision($submission, $revisionRequest);
                    return;
                }

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

    // ── Private helpers ──────────────────────────────────────────────────────

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
                'role' => 'author',
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
        }
    }

    private static function notifyChiefEditorOfRevision(Submission $submission, RevisionRequest $revisionRequest): void
    {
        $chefEditor = $submission->initialScreeningBy;
        if (!$chefEditor) return;

        \App\Models\Notification::create([
            'user_id' => $chefEditor->id,
            'role' => 'editor-in-chief',
            'title' => '📄 Revised Manuscript Submitted (Re-Screening Required)',
            'message' => "Author has submitted revision for \"{$submission->title}\" per your initial screening request.\n\nAuthor's Notes: {$revisionRequest->revision_notes}",
            'type' => 'info',
            'notifiable_id' => $submission->id,
            'notifiable_type' => Submission::class,
        ]);
    }

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
                'role' => 'editor',
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
        }
    }

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
                    'role' => 'reviewer',
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
        }
    }
}