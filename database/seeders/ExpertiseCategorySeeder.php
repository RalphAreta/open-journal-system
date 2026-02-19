<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpertiseCategorySeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'Science & Technology',
            'Engineering',
            'Health & Medical Sciences',
            'Information Systems',
            'Computer Science',
            'Business & Management',
            'Education',
            'Social Sciences',
            'Environmental Sciences',
            'Mathematics & Statistics',
            'Humanities',
        ];

        foreach ($defaults as $name) {
            DB::table('expertise_categories')->updateOrInsert(
                ['name' => $name],
                ['name' => $name, 'is_custom' => false, 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}