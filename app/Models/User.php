<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user')->withTimestamps();
    }

    public function submissionsAsAuthor(): HasMany
    {
        return $this->hasMany(Submission::class, 'author_id');
    }

    public function submissionsAsEditor(): HasMany
    {
        return $this->hasMany(Submission::class, 'editor_id');
    }

    public function reviewAssignments(): HasMany
    {
        return $this->hasMany(ReviewAssignment::class, 'reviewer_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function hasRole(string $roleName): bool
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isEditor(): bool
    {
        return $this->hasRole('editor');
    }

    public function isReviewer(): bool
    {
        return $this->hasRole('reviewer');
    }

    public function isAuthor(): bool
    {
        return $this->hasRole('author');
    }

    /** Get primary role for dashboard redirect (admin > editor > reviewer > author). */
    public function primaryRole(): ?Role
    {
        $order = ['admin', 'editor', 'reviewer', 'author'];
        foreach ($order as $name) {
            $role = $this->roles()->where('name', $name)->first();
            if ($role) {
                return $role;
            }
        }
        return null;
    }
}
