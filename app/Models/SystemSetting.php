<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SystemSetting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'group'];

    /**
     * Get a setting value by key.
     */
    public static function getValue(string $key, mixed $default = null): mixed
    {
        $cacheKey = 'system_setting_' . $key;
        $setting = Cache::remember($cacheKey, 3600, function () use ($key) {
            return static::where('key', $key)->first();
        });

        if (! $setting) {
            return $default;
        }

        return static::castValue($setting->value, $setting->type);
    }

    /**
     * Set a setting value.
     */
    public static function setValue(string $key, mixed $value, string $type = 'string', string $group = 'general'): void
    {
        $valueStr = is_string($value) ? $value : json_encode($value);
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $valueStr, 'type' => $type, 'group' => $group]
        );
        Cache::forget('system_setting_' . $key);
    }

    protected static function castValue(string $value, string $type): mixed
    {
        return match ($type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $value,
            'json' => json_decode($value, true),
            default => $value,
        };
    }
}
