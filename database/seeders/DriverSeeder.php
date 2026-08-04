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
        $drivers = [
            ['nama_driver' => 'Budi Santoso', 'no_telp' => '082111111111', 'alamat' => 'Jl. Merdeka No. 1, Jakarta', 'sim' => 'B1', 'tarif_per_hari' => 150000, 'status' => 'aktif', 'foto' => 'drivers/driver1.jpg'],
            ['nama_driver' => 'Agus Wijaya', 'no_telp' => '082122222222', 'alamat' => 'Jl. Sudirman No. 10, Jakarta', 'sim' => 'B1', 'tarif_per_hari' => 150000, 'status' => 'aktif', 'foto' => 'drivers/driver2.jpg'],
            ['nama_driver' => 'Dedi Kurniawan', 'no_telp' => '082133333333', 'alamat' => 'Jl. Gatot Subroto No. 20, Jakarta', 'sim' => 'B2', 'tarif_per_hari' => 200000, 'status' => 'aktif', 'foto' => 'drivers/driver3.jpg'],
            ['nama_driver' => 'Eko Prasetyo', 'no_telp' => '082144444444', 'alamat' => 'Jl. Thamrin No. 5, Jakarta', 'sim' => 'B1', 'tarif_per_hari' => 150000, 'status' => 'aktif', 'foto' => 'drivers/driver4.jpg'],
            ['nama_driver' => 'Fahmi Hidayat', 'no_telp' => '082155555555', 'alamat' => 'Jl. Kuningan No. 15, Jakarta', 'sim' => 'B1', 'tarif_per_hari' => 150000, 'status' => 'tidak_aktif', 'foto' => 'drivers/driver5.jpg'],
            ['nama_driver' => 'Gunawan Setiawan', 'no_telp' => '082166666666', 'alamat' => 'Jl. Rasuna Said No. 25, Jakarta', 'sim' => 'B2', 'tarif_per_hari' => 250000, 'status' => 'aktif', 'foto' => 'drivers/driver6.jpg'],
            ['nama_driver' => 'Hendra Wijaya', 'no_telp' => '082177777777', 'alamat' => 'Jl. Senopati No. 12, Jakarta', 'sim' => 'B1', 'tarif_per_hari' => 175000, 'status' => 'aktif', 'foto' => 'drivers/driver7.jpg'],
            ['nama_driver' => 'Iwan Kurnia', 'no_telp' => '082188888888', 'alamat' => 'Jl. Pondok Indah No. 8, Jakarta', 'sim' => 'B1', 'tarif_per_hari' => 150000, 'status' => 'aktif', 'foto' => 'drivers/driver8.jpg'],
        ];

        foreach ($drivers as $driver) {
            Driver::updateOrCreate(
                ['no_telp' => $driver['no_telp']],
                $driver
            );
        }
    }
}