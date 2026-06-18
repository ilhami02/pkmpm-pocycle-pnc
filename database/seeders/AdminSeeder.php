<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Buat admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@pocycle.com'],
            [
                'name' => 'Admin POCYCLE',
                'password' => Hash::make('password'), // Password default: password
                'email_verified_at' => now(),
            ]
        );

        // Pastikan dia jadi admin
        $admin->update(['is_admin' => true]);

        // Buat user biasa untuk testing
        User::firstOrCreate(
            ['email' => 'test@test.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_admin' => false,
            ]
        );
    }
}
