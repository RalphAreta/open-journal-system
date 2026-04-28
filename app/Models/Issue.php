<?php
// app/Models/Issue.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Issue extends Model
{
    protected $fillable = ['volume_id', 'number', 'cover_image'];

    public function volume(): BelongsTo
    {
        return $this->belongsTo(Volume::class);
    }
}