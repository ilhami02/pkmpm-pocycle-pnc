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
            ['phone' => '081234567890'],
            [
                'name' => 'Admin POCYCLE',
                'username' => 'admin',
                'password' => Hash::make('password'), // Password default: password
            ]
        );

        // Pastikan dia jadi admin
        $admin->update(['is_admin' => true]);

        // Buat user biasa untuk testing
        User::firstOrCreate(
            ['phone' => '089876543210'],
            [
                'name' => 'Test User',
                'username' => 'testuser',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );
    }
}
