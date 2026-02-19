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
        return ExpertiseCategory::getFieldOptions();
    }
}