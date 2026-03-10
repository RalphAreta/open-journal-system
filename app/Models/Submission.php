<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Submission extends Model
{
    protected $fillable = [
        'author_id',
        'title',
        'abstract',
        'keywords',
        'research_field',
        'file_path',
        'file_name',
        'original_file_path',
        'original_file_name',
        'status',
        'editor_id',
        'assigned_editor_id',
        'submitted_at',
        'chief_editor_review_at',
        'editor_decision_at',
        'editor_notes',
        'chief_editor_notes',
        'initial_screening_status',
        'initial_screening_comments',
        'initial_screening_by',
        'initial_screening_at',
        'editor_decision_draft',
        'managing_editor_id',
'managing_editor_assigned_at',
'managing_editor_status',
'ctf_sent_at',
'forwarded_to_layout_at',
'ctf_file_path',
'ctf_file_name',
'ctf_signed_file_path',   // ← dagdag
'ctf_signed_file_name',   // ← dagdag
'ctf_returned_at',   
'published_at',
  'author_feedback',
    'author_feedback_at',
    'author_status',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'chief_editor_review_at' => 'datetime',
            'editor_decision_at' => 'datetime',
            'initial_screening_at' => 'datetime',
            'managing_editor_assigned_at' => 'datetime',
            'ctf_sent_at' => 'datetime',
            'ctf_returned_at' => 'datetime', 
            'forwarded_to_layout_at' => 'datetime',
            'published_at' => 'datetime',
            'editor_decision_draft' => 'json',
            'author_feedback_at' => 'datetime',
        ];
    }

    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_UNDER_REVIEW = 'under_review';
    public const STATUS_REVISIONS_REQUESTED = 'revisions_requested';
    public const STATUS_REVISION_UNDER_REVIEW = 'revision_under_review';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_WITH_MANAGING_EDITOR = 'with_managing_editor';
    public const STATUS_LAYOUT_EDITING = 'layout_editing';
    public const STATUS_LAYOUT_REVIEW = 'layout_review';
    public const STATUS_AUTHOR_CONFIRMATION = 'author_confirmation';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_REJECTED = 'rejected';

    public const SCREENING_STATUS_PENDING = 'pending';
    public const SCREENING_STATUS_PASSED = 'passed';
    public const SCREENING_STATUS_FAILED = 'failed';

    public const AUTHOR_STATUS_CONFIRMED = 'confirmed';
public const AUTHOR_STATUS_REVISION = 'revision_requested';

    public static function statusOptions(): array
    {
        return [
            self::STATUS_SUBMITTED => 'Submitted',
            self::STATUS_UNDER_REVIEW => 'Under Review',
            self::STATUS_REVISIONS_REQUESTED => 'Revisions Requested',
            self::STATUS_REVISION_UNDER_REVIEW => 'Revision Under Review',
            self::STATUS_ACCEPTED => 'Accepted',
            self::STATUS_LAYOUT_EDITING => 'Layout Editing',
            self::STATUS_LAYOUT_REVIEW => 'Layout Review',
            self::STATUS_AUTHOR_CONFIRMATION => 'Author Confirmation',
            self::STATUS_PUBLISHED => 'Published',
            self::STATUS_WITH_MANAGING_EDITOR => 'With Managing Editor',
            self::STATUS_REJECTED => 'Rejected',
        ];
    }

    public static function screeningStatusOptions(): array
    {
        return [
            self::SCREENING_STATUS_PENDING => 'Pending',
            self::SCREENING_STATUS_PASSED => 'Passed',
            self::SCREENING_STATUS_FAILED => 'Failed',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id');
    }

    public function reviewAssignments(): HasMany
    {
        return $this->hasMany(ReviewAssignment::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function assignedEditor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_editor_id');
    }

    public function managingEditor(): BelongsTo
{
    return $this->belongsTo(User::class, 'managing_editor_id');
}

    public function initialScreeningBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'initial_screening_by');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(SubmissionAssignment::class);
    }

    public function revisionRequests(): HasMany
    {
        return $this->hasMany(RevisionRequest::class);
    }

    public function appeals(): HasMany
    {
        return $this->hasMany(Appeal::class);
    }

    public function layoutEditorAssignments(): HasMany
    {
        return $this->hasMany(LayoutEditorAssignment::class);
    }

    public function isEditableByAuthor(): bool
    {
        return in_array($this->status, [self::STATUS_SUBMITTED, self::STATUS_REVISIONS_REQUESTED]);
    }

    public function hasPassedInitialScreening(): bool
    {
        return $this->initial_screening_status === self::SCREENING_STATUS_PASSED;
    }

    public function isPendingInitialScreening(): bool
    {
        return $this->initial_screening_status === self::SCREENING_STATUS_PENDING;
    }

    public function hasFailedInitialScreening(): bool
    {
        return $this->initial_screening_status === self::SCREENING_STATUS_FAILED;
    }

    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }
}
