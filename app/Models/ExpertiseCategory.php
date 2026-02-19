<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpertiseCategory extends Model
{
    protected $fillable = ['name', 'is_custom'];

    protected $casts = [
        'is_custom' => 'boolean',
    ];

    /** Returns all categories (default + custom) as a flat name => name array for select dropdowns */
    public static function getFieldOptions(): array
    {
        return self::orderBy('is_custom')->orderBy('name')
            ->pluck('name', 'name')
            ->toArray();
    }
}