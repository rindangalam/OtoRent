<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $users = [
            ['name' => 'Admin OtoRent', 'email' => 'admin@otorent.com', 'phone' => '081234567890', 'role' => Role::Admin],
            ['name' => 'Staff OtoRent', 'email' => 'staff@otorent.com', 'phone' => '081234567891', 'role' => Role::Staff],
            ['name' => 'Reza Mahendra', 'email' => 'reza@otorent.com', 'phone' => '081234567892', 'role' => Role::Staff],
            ['name' => 'Andi Pratama', 'email' => 'andi@example.com', 'phone' => '081234567893', 'role' => Role::Customer],
            ['name' => 'Budi Santoso', 'email' => 'budi@example.com', 'phone' => '081234567894', 'role' => Role::Customer],
            ['name' => 'Citra Dewi', 'email' => 'citra@example.com', 'phone' => '081234567895', 'role' => Role::Customer],
            ['name' => 'Dewi Lestari', 'email' => 'dewi@example.com', 'phone' => '081234567896', 'role' => Role::Customer],
            ['name' => 'Eka Saputra', 'email' => 'eka@example.com', 'phone' => '081234567897', 'role' => Role::Customer],
            ['name' => 'Fajar Nugroho', 'email' => 'fajar@example.com', 'phone' => '081234567898', 'role' => Role::Customer],
            ['name' => 'Gilang Ramadhan', 'email' => 'gilang@example.com', 'phone' => '081234567899', 'role' => Role::Customer],
            ['name' => 'Hana Salsabila', 'email' => 'hana@example.com', 'phone' => '081234567810', 'role' => Role::Customer],
            ['name' => 'Irfan Hakim', 'email' => 'irfan@example.com', 'phone' => '081234567811', 'role' => Role::Customer],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'phone' => $user['phone'],
                    'role' => $user['role'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
