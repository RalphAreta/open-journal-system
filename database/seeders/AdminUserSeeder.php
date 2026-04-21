<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        $adminUsers = [
            [
                'email' => 'admin@ojs.local',
                'name' => 'Admin',
                'password' => 'password',
            ],
            [
                'email' => 'admin@ojs.com',
                'name' => 'Admin',
                'password' => 'password',
            ],
        ];

        foreach ($adminUsers as $adminUser) {
            $admin = User::firstOrCreate(
                ['email' => $adminUser['email']],
                [
                    'name' => $adminUser['name'],
                    'password' => Hash::make($adminUser['password']),
                ]
            );

            if ($adminRole && ! $admin->roles()->where('role_id', $adminRole->id)->exists()) {
                $admin->roles()->attach($adminRole->id);
            }
        }
    }
}
