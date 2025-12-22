<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@himalayavoyage.com',
            'password' => Hash::make('password'),
            'phone' => '9800000000',
            'role' => 'admin',
            'email_verified_at' => now(),
            'status' => true,
        ]);

        // Create Demo Regular User
        User::create([
            'name' => 'Abhishek Adhikari',
            'email' => 'avisek@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '98246801',
            'role' => 'user',
            'email_verified_at' => now(),
            'status' => true,
            'loyalty_points' => 100,
        ]);

        // Create more demo users
        User::create([
            'name' => 'Gunjan Kandel',
            'email' => 'gunjan@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '9847098765',
            'role' => 'user',
            'email_verified_at' => now(),
            'status' => true,
            'loyalty_points' => 250,
        ]);

        User::create([
            'name' => 'Michael Chen',
            'email' => 'ayush@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '9845123456',
            'role' => 'user',
            'email_verified_at' => now(),
            'status' => true,
            'loyalty_points' => 500,
        ]);
    }
}