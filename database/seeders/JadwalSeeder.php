<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\Jadwal;
use App\Models\Kendaraan;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $today = Carbon::today();

        $data = [
            // [nama driver, plat kendaraan, hari (+), status]
            ['Budi Santoso', 'B 1234 CD', 1, 'tersedia'],
            ['Agus Wijaya', 'B 2345 DE', 1, 'tersedia'],
            ['Dedi Kurniawan', 'B 3456 EF', 1, 'tersedia'],
            ['Eko Prasetyo', 'B 6789 HI', 1, 'tersedia'],
            ['Budi Santoso', 'B 1234 CD', 2, 'tersedia'],
            ['Agus Wijaya', 'B 2345 DE', 2, 'tersedia'],
            ['Gunawan Setiawan', 'B 1234 KL', 2, 'tersedia'],
            ['Hendra Wijaya', 'B 4567 FG', 3, 'tersedia'],
            ['Iwan Kurnia', 'B 8901 JK', 3, 'tersedia'],
            ['Fahmi Hidayat', 'B 6789 HI', 3, 'tidak_tersedia'],
            ['Eko Prasetyo', 'B 9012 KL', 4, 'tidak_tersedia'],
            ['Gunawan Setiawan', 'B 2345 LM', 5, 'tersedia'],
        ];

        foreach ($data as [$namaDriver, $plat, $hari, $status]) {
            $driver = Driver::where('nama_driver', $namaDriver)->first();
            $kendaraan = Kendaraan::where('plat_nomor', $plat)->first();
            if (!$driver || !$kendaraan) {
                continue;
            }

            Jadwal::updateOrCreate(
                [
                    'driver_id' => $driver->id,
                    'kendaraan_id' => $kendaraan->id,
                    'tanggal' => $today->copy()->addDays($hari),
                ],
                [
                    'waktu_mulai' => '08:00',
                    'waktu_selesai' => '17:00',
                    'status' => $status,
                ]
            );
        }
    }
}