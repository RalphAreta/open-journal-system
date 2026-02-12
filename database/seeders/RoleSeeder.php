<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'display_name' => 'Administrator', 'description' => 'Full system access'],
            ['name' => 'editor', 'display_name' => 'Editor', 'description' => 'Manage submissions and make editorial decisions'],
            ['name' => 'reviewer', 'display_name' => 'Reviewer', 'description' => 'Review assigned submissions'],
            ['name' => 'author', 'display_name' => 'Author', 'description' => 'Submit and manage own articles'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                $role
            );
        }
    }
}
