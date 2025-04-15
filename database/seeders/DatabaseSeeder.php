<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);
    
        User::create([
            'name' => 'User',
            'email' => 'user@email.com',
            'password' => Hash::make('password'),
            'role' => 'user'
        ]);
    }
}
