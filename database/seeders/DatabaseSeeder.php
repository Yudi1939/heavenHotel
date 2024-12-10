<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin123@gmail.com',
            'password' => bcrypt('password'), // Pastikan untuk mengganti dengan password yang aman
            'role' => 'admin',
        ]);
    }
}
