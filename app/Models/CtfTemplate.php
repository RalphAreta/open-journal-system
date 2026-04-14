<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CtfTemplate extends Model
{
    protected $fillable = [
        'file_path',
        'file_name',
        'is_released',
        'uploaded_by',
        'released_at',
    ];

    protected $casts = [
        'is_released'  => 'boolean',
        'released_at'  => 'datetime',
    ];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}