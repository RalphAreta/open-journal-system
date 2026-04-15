<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditorialBoardMember extends Model
{
    protected $fillable = [
        'title',
        'name',
        'role',
        'affiliation',
        'location',
        'expertise',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

   
    public function getInitialsAttribute(): string
{
    $words = explode(' ', $this->name);
    $initials = '';
    foreach (array_slice($words, 0, 2) as $word) {
        $initials .= strtoupper($word[0] ?? '');
    }
    return $initials;
}

public function getFullNameAttribute(): string
{
    return trim($this->title . ' ' . $this->name);
}

public function getRoleLabelAttribute(): string
{
    $roles = [
        'editor_in_chief'  => 'Editor-in-Chief',
        'associate_editor' => 'Associate Editor',
        'section_editor'   => 'Section Editor',
        'reviewer'         => 'Reviewer',
        'advisor'          => 'Advisory Board',
    ];
    return $roles[$this->role] ?? ucwords(str_replace('_', ' ', $this->role));
}
}