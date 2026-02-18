<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EditorExpertise extends Model
{
    protected $table = 'editor_expertise';

    protected $fillable = [
        'user_id',
        'field_name',
        'description',
    ];

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function getFieldOptions(): array
    {
        return [
            'Science & Technology' => 'Science & Technology',
            'Engineering' => 'Engineering',
            'Health & Medical Sciences' => 'Health & Medical Sciences',
            'Information Systems' => 'Information Systems',
            'Computer Science' => 'Computer Science',
            'Business & Management' => 'Business & Management',
            'Education' => 'Education',
            'Social Sciences' => 'Social Sciences',
            'Environmental Sciences' => 'Environmental Sciences',
            'Mathematics & Statistics' => 'Mathematics & Statistics',
            'Humanities' => 'Humanities',
            'Other' => 'Other',
        ];
    }
}
