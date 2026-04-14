<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'submission_id',
        'reviewer_id',
        'review_assignment_id',
        'referee_invitation_id',
        'recommendation',
        'comments_for_author',
        'comments_for_editor',
        'rating',
        'status',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
        ];
    }

    public const STATUS_DRAFT = 'draft';
    public const STATUS_SUBMITTED = 'submitted';

    public const RECOMMEND_ACCEPT = 'accept';
    public const RECOMMEND_MINOR_REVISIONS = 'minor_revisions';
    public const RECOMMEND_MODERATE_REVISIONS = 'moderate_revisions';
    public const RECOMMEND_MAJOR_REVISIONS = 'major_revisions';
    public const RECOMMEND_REJECT = 'reject';

    public static function recommendationOptions(): array
    {
        return [
            self::RECOMMEND_ACCEPT => 'Accept',
            self::RECOMMEND_MINOR_REVISIONS => 'Minor Revisions',
            self::RECOMMEND_MODERATE_REVISIONS => 'Moderate Revisions',
            self::RECOMMEND_MAJOR_REVISIONS => 'Major Revisions',
            self::RECOMMEND_REJECT => 'Reject',
        ];
    }

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function reviewAssignment(): BelongsTo
    {
        return $this->belongsTo(ReviewAssignment::class);
    }

    public function refereeInvitation(): BelongsTo
    {
        return $this->belongsTo(RefereeInvitation::class);
    }

    /**
     * Get rating interpretation
     */
    public function getRatingInterpretation(): ?string
    {
        if (!$this->rating) {
            return null;
        }
        return \App\Services\RatingScale::interpretRating($this->rating);
    }

    /**
     * Get rating guidance
     */
    public function getRatingGuidance(): ?string
    {
        if (!$this->rating) {
            return null;
        }
        return \App\Services\RatingScale::getGuidanceForRating($this->rating, 'reviewer');
    }
}
