<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'author',          'display_name' => 'Author',          'description' => 'Submit and manage own articles'],
            ['name' => 'reviewer',        'display_name' => 'Reviewer',        'description' => 'Review assigned submissions'],
            ['name' => 'editor',          'display_name' => 'Editor',          'description' => 'Manage submissions and make editorial decisions'],
            ['name' => 'editor-in-chief', 'display_name' => 'Editor in Chief', 'description' => 'Oversee all editorial operations and final decisions'],
            ['name' => 'layout-editor',   'display_name' => 'Layout Editor',   'description' => 'Edit and format accepted manuscripts'],
            ['name' => 'admin',           'display_name' => 'Admin',           'description' => 'Full system administration access'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['name' => $role['name']],
                array_merge($role, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }
}