<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create test users
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'user@haven.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '+1 (555) 123-4567',
                'address' => '123 Main Street, New York, NY 10001',
                'is_active' => true,
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '+1 (555) 234-5678',
                'address' => '456 Oak Avenue, Los Angeles, CA 90001',
                'is_active' => true,
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '+1 (555) 345-6789',
                'address' => '789 Pine Road, Chicago, IL 60601',
                'is_active' => true,
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
