<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\MassPrunable;

class PendingRegistration extends Model
{
    use MassPrunable;

    protected $fillable = [
        'email',
        'token',
        'payload',
        'attempts',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'attempts'   => 'integer',
    ];

    // Auto-prune expired records
    public function prunable()
    {
        return static::where('expires_at', '<', now());
    }
}