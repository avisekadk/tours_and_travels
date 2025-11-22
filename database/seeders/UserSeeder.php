<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@himalayavoyage.com',
            'phone' => '+977-9841234567',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status' => true,
            'email_verified_at' => now(),
        ]);

        // Create regular user
        User::create([
            'name' => 'avisekadk',
            'email' => 'avizekadk@gmail.com',
            'phone' => '+977-9841234568',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'status' => true,
            'email_verified_at' => now(),
        ]);
    }
}