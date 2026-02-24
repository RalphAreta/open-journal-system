<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class ReviewAssignment extends Model
{
    protected $fillable = [
        'submission_id',
        'reviewer_id',
        'assigned_by',
        'referee_invitation_id',
        'status',
        'due_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'due_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public const STATUS_ASSIGNED = 'assigned';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_DECLINED = 'declined';

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    public function refereeInvitation(): BelongsTo
    {
        return $this->belongsTo(RefereeInvitation::class);
    }

    public function revisionRequest(): HasOneThrough
    {
        return $this->hasOneThrough(
            RevisionRequest::class,
            Submission::class,
            'id',
            'submission_id',
            'submission_id',
            'id'
        );
    }
}
