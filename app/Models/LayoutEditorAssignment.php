<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LayoutEditorAssignment extends Model
{
    protected $fillable = [
        'submission_id',
        'layout_editor_id',
        'assigned_at',
        'started_at',
        'completed_at',
        'layout_file_path',
        'layout_file_name',
        'notes',
        'status',
        'author_feedback',
        'author_feedback_at',
        'author_status',
    ];

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'author_feedback_at' => 'datetime',
        ];
    }

    public const STATUS_PENDING = 'pending';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_REJECTED = 'rejected';

    // ← DAGDAG DITO
public const AUTHOR_STATUS_CONFIRMED = 'confirmed';
public const AUTHOR_STATUS_REVISION = 'revision_requested';

    public static function statusOptions(): array
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_REJECTED => 'Rejected',
        ];
    }

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    public function layoutEditor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'layout_editor_id');
    }


}
