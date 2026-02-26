<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyVisitor extends Model
{
    use HasFactory;

    protected $table = 'daily_visitors';

    protected $fillable = [
        'date',
        'count',
    ];

    protected $casts = [
        'count' => 'integer',
        'date' => 'date',
    ];
}
