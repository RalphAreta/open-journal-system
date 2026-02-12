<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'journal_name', 'value' => 'Open Journal System', 'type' => 'string', 'group' => 'general'],
            ['key' => 'journal_description', 'value' => 'A simple open journal system.', 'type' => 'string', 'group' => 'general'],
            ['key' => 'submissions_open', 'value' => '1', 'type' => 'boolean', 'group' => 'submissions'],
        ];

        foreach ($settings as $setting) {
            SystemSetting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
