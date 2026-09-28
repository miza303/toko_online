<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@toko.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Kantor Pusat Toko Online',
        ]);

        User::create([
            'name' => 'Budi Pembeli',
            'email' => 'customer@toko.test',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '081298765432',
            'address' => 'Jl. Contoh No. 123, Surakarta',
        ]);
    }
}
