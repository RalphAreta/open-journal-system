<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubmissionAssignment extends Model
{
    protected $fillable = [
        'submission_id',
        'assigned_to_user_id',
        'assigned_by_user_id',
        'expertise_field',
        'assignment_notes',
        'assigned_at',
        'accepted_at',
        'rejected_at',
    ];

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'accepted_at' => 'datetime',
            'rejected_at' => 'datetime',
        ];
    }

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by_user_id');
    }

    public function isAccepted(): bool
    {
        return $this->accepted_at !== null;
    }

    public function isRejected(): bool
    {
        return $this->rejected_at !== null;
    }

    public function isPending(): bool
    {
        return $this->accepted_at === null && $this->rejected_at === null;
    }
}
