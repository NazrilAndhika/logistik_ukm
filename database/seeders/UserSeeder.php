<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat Akun Admin
        User::create([
            'name' => 'Admin Logistik',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'), // Passwordnya: password123
            'role' => 'admin',
            'no_hp' => '081234567890'
        ]);
    }
}