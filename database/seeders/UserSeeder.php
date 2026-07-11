<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::create([
            'name' => 'Admin OtoRent',
            'email' => 'admin@otorent.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Staff OtoRent',
            'email' => 'staff@otorent.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'phone' => '081234567891',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Andi Pratama',
            'email' => 'andi@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '081234567892',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '081234567893',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Citra Dewi',
            'email' => 'citra@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '081234567894',
            'email_verified_at' => now(),
        ]);
    }
}
