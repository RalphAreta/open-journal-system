<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RevisionRequest extends Model
{
    protected $fillable = [
        'submission_id',
        'requested_by_user_id',
        'revision_type',
        'reason',
        'requested_at',
        'revised_submission_id',
        'revised_at',
        'revision_notes',
    ];

    protected function casts(): array
    {
        return [
            'requested_at' => 'datetime',
            'revised_at' => 'datetime',
        ];
    }

    public const REVISION_MINOR = 'minor';
    public const REVISION_MAJOR = 'major';

    public static function revisionTypeLabels(): array
    {
        return [
            self::REVISION_MINOR => 'Minor Revisions',
            self::REVISION_MAJOR => 'Major Revisions',
        ];
    }

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by_user_id');
    }

    public function revisedSubmission(): BelongsTo
    {
        return $this->belongsTo(Submission::class, 'revised_submission_id');
    }

    public function revisionReviews(): HasMany
    {
        return $this->hasMany(RevisionReview::class);
    }

    public function isResolved(): bool
    {
        return $this->revised_at !== null;
    }

    public function isPending(): bool
    {
        return $this->revised_at === null;
    }

    protected static function booted(): void
    {
        static::addGlobalScope('pending', function ($query) {
            // No global scope, just add a method instead
        });
    }

    public function scopePending($query)
    {
        return $query->whereNull('revised_at');
    }
}
