<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin@123')
            ]
        ];

        // Loop through each user item and create or update it by key
        foreach ($userData as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],  // Search by key
                [
                    'name' => $user['name'],  // Update or create with new value
                    'password' => $user['password']
                ]
            );
        }
    }
}
