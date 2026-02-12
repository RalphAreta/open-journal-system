<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = ['name', 'display_name', 'description'];

    /**
     * Users that have this role.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user')->withTimestamps();
    }

    /**
     * Check if role is admin.
     */
    public function isAdmin(): bool
    {
        return $this->name === 'admin';
    }

    /**
     * Check if role is editor.
     */
    public function isEditor(): bool
    {
        return $this->name === 'editor';
    }

    /**
     * Check if role is reviewer.
     */
    public function isReviewer(): bool
    {
        return $this->name === 'reviewer';
    }

    /**
     * Check if role is author.
     */
    public function isAuthor(): bool
    {
        return $this->name === 'author';
    }
}
