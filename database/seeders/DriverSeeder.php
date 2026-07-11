<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Driver::create([
            'nama_driver' => 'Budi Santoso',
            'no_telp' => '082111111111',
            'alamat' => 'Jl. Merdeka No. 1, Jakarta',
            'sim' => 'B1',
            'tarif_per_hari' => 150000,
            'status' => 'aktif',
            'foto' => 'drivers/budi.jpg',
        ]);

        Driver::create([
            'nama_driver' => 'Agus Wijaya',
            'no_telp' => '082122222222',
            'alamat' => 'Jl. Sudirman No. 10, Jakarta',
            'sim' => 'B1',
            'tarif_per_hari' => 150000,
            'status' => 'aktif',
            'foto' => 'drivers/agus.jpg',
        ]);

        Driver::create([
            'nama_driver' => 'Dedi Kurniawan',
            'no_telp' => '082133333333',
            'alamat' => 'Jl. Gatot Subroto No. 20, Jakarta',
            'sim' => 'B2',
            'tarif_per_hari' => 200000,
            'status' => 'aktif',
            'foto' => 'drivers/dedi.jpg',
        ]);

        Driver::create([
            'nama_driver' => 'Eko Prasetyo',
            'no_telp' => '082144444444',
            'alamat' => 'Jl. Thamrin No. 5, Jakarta',
            'sim' => 'B1',
            'tarif_per_hari' => 150000,
            'status' => 'sedang_bertugas',
            'foto' => 'drivers/eko.jpg',
        ]);

        Driver::create([
            'nama_driver' => 'Fahmi Hidayat',
            'no_telp' => '082155555555',
            'alamat' => 'Jl. Kuningan No. 15, Jakarta',
            'sim' => 'B1',
            'tarif_per_hari' => 150000,
            'status' => 'tidak_aktif',
            'foto' => 'drivers/fahmi.jpg',
        ]);
    }
}
