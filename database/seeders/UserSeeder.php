<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->syncRoles('Super Admin');

        $admin = User::firstOrCreate(
            ['email' => 'admin.lab@example.com'],
            [
                'name' => 'Admin Labkesda',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->syncRoles('Admin');

        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Staff User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $user->syncRoles('User');
    }
}
