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
        'status',
        'editor_id',
        'assigned_editor_id',
        'submitted_at',
        'chief_editor_review_at',
        'editor_decision_at',
        'editor_notes',
        'chief_editor_notes',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'chief_editor_review_at' => 'datetime',
            'editor_decision_at' => 'datetime',
        ];
    }

    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_UNDER_REVIEW = 'under_review';
    public const STATUS_REVISIONS_REQUESTED = 'revisions_requested';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_REJECTED = 'rejected';

    public static function statusOptions(): array
    {
        return [
            self::STATUS_SUBMITTED => 'Submitted',
            self::STATUS_UNDER_REVIEW => 'Under Review',
            self::STATUS_REVISIONS_REQUESTED => 'Revisions Requested',
            self::STATUS_ACCEPTED => 'Accepted',
            self::STATUS_REJECTED => 'Rejected',
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

    public function assignments(): HasMany
    {
        return $this->hasMany(SubmissionAssignment::class);
    }

    public function revisionRequests(): HasMany
    {
        return $this->hasMany(RevisionRequest::class);
    }

    public function isEditableByAuthor(): bool
    {
        return in_array($this->status, [self::STATUS_SUBMITTED, self::STATUS_REVISIONS_REQUESTED]);
    }
}
