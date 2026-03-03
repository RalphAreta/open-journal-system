<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingCriteria extends Model
{
    protected $table = 'rating_criterias';

    protected $fillable = [
        'role',
        'context',
        'band',
        'label',
        'description',
        'characteristics',
        'score_min',
        'score_max',
    ];

    protected $casts = [
        'characteristics' => 'array',
    ];

    /**
     * Get criteria for a specific role and band
     */
    public static function getForRoleAndBand(string $role, string $band, string $context = 'general'): ?self
    {
        return self::where('role', $role)
            ->where('band', $band)
            ->where('context', $context)
            ->first();
    }

    /**
     * Get all criteria for a role
     */
    public static function getForRole(string $role, string $context = 'general'): array
    {
        return self::where('role', $role)
            ->where('context', $context)
            ->orderBy('score_min')
            ->get()
            ->mapWithKeys(fn($item) => [$item->band => $item->toArray()])
            ->toArray();
    }

    /**
     * Get label for a given rating and role
     */
    public static function getLabelForRating(int $rating, string $role, string $context = 'general'): ?string
    {
        $criteria = self::where('role', $role)
            ->where('context', $context)
            ->where('score_min', '<=', $rating)
            ->where('score_max', '>=', $rating)
            ->first();

        return $criteria?->label;
    }

    /**
     * Get description for a given rating and role
     */
    public static function getDescriptionForRating(int $rating, string $role, string $context = 'general'): ?string
    {
        $criteria = self::where('role', $role)
            ->where('context', $context)
            ->where('score_min', '<=', $rating)
            ->where('score_max', '>=', $rating)
            ->first();

        return $criteria?->description;
    }

    /**
     * Get characteristics for a given rating and role
     */
    public static function getCharacteristicsForRating(int $rating, string $role, string $context = 'general'): ?array
    {
        $criteria = self::where('role', $role)
            ->where('context', $context)
            ->where('score_min', '<=', $rating)
            ->where('score_max', '>=', $rating)
            ->first();

        return $criteria?->characteristics;
    }
}
