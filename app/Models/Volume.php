<?php
// app/Models/Volume.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Volume extends Model
{
    protected $fillable = ['number', 'year'];

    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class)->orderBy('number');
    }
}