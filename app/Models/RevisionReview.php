<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RevisionReview extends Model
{
    protected $fillable = [
        'revision_request_id',
        'reviewer_id',
        'status',
        'recommendation',
        'comments_for_author',
        'comments_for_editor',
        'rating',
        'submission_status',
        'assigned_at',
        'completed_at',
        'due_at',
    ];

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'completed_at' => 'datetime',
            'due_at' => 'datetime',
        ];
    }

    public const STATUS_ASSIGNED = 'assigned';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_DECLINED = 'declined';

    public const SUBMISSION_STATUS_DRAFT = 'draft';
    public const SUBMISSION_STATUS_SUBMITTED = 'submitted';

    public const RECOMMEND_ACCEPT = 'accept';
    public const RECOMMEND_MINOR_REVISIONS = 'minor_revisions';
    public const RECOMMEND_MAJOR_REVISIONS = 'major_revisions';
    public const RECOMMEND_REJECT = 'reject';

    public static function recommendationOptions(): array
    {
        return [
            self::RECOMMEND_ACCEPT => 'Accept',
            self::RECOMMEND_MINOR_REVISIONS => 'Minor Revisions',
            self::RECOMMEND_MAJOR_REVISIONS => 'Major Revisions',
            self::RECOMMEND_REJECT => 'Reject',
        ];
    }

    public function revisionRequest(): BelongsTo
    {
        return $this->belongsTo(RevisionRequest::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
