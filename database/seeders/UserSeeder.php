<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@sociolla.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]);
        \App\Models\User::create([
            'name' => 'Petugas User',
            'email' => 'petugas@sociolla.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'petugas',
        ]);
        \App\Models\User::create([
            'name' => 'Faynaliza',
            'email' => 'faynaliza@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'phone' => '(+62) 812-3456-7890',
            'birth_date' => '2008-03-16',
            'role' => 'user',
        ]);
    }
}
