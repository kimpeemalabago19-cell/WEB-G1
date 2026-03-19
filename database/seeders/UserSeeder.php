<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['username' => 'admin'],

            [
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Create test user
        User::firstOrCreate(
            ['username' => 'user'],

            [
                'username' => 'user',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]
        );
    }
}

