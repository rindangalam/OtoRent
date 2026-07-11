<?php

namespace Database\Seeders;

use App\Models\Jadwal;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $besok = Carbon::today()->addDay();
        $lusa = Carbon::today()->addDays(2);

        // Jadwal 1: Budi Santoso (driver_id=1) - Avanza (kendaraan_id=1) - besok
        Jadwal::create([
            'driver_id' => 1,
            'kendaraan_id' => 1,
            'tanggal' => $besok,
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '17:00',
            'status' => 'tersedia',
        ]);

        // Jadwal 2: Agus Wijaya (driver_id=2) - Xenia (kendaraan_id=2) - besok
        Jadwal::create([
            'driver_id' => 2,
            'kendaraan_id' => 2,
            'tanggal' => $besok,
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '17:00',
            'status' => 'tersedia',
        ]);

        // Jadwal 3: Dedi Kurniawan (driver_id=3) - Innova (kendaraan_id=3) - besok
        Jadwal::create([
            'driver_id' => 3,
            'kendaraan_id' => 3,
            'tanggal' => $besok,
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '17:00',
            'status' => 'tersedia',
        ]);

        // Jadwal 4: Budi Santoso (driver_id=1) - Avanza (kendaraan_id=1) - lusa
        Jadwal::create([
            'driver_id' => 1,
            'kendaraan_id' => 1,
            'tanggal' => $lusa,
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '17:00',
            'status' => 'tersedia',
        ]);

        // Jadwal 5: Agus Wijaya (driver_id=2) - Xenia (kendaraan_id=2) - lusa
        Jadwal::create([
            'driver_id' => 2,
            'kendaraan_id' => 2,
            'tanggal' => $lusa,
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '17:00',
            'status' => 'tersedia',
        ]);

        // Jadwal 6: Dedi Kurniawan (driver_id=3) - Fortuner (kendaraan_id=5) - lusa
        Jadwal::create([
            'driver_id' => 3,
            'kendaraan_id' => 5,
            'tanggal' => $lusa,
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '17:00',
            'status' => 'tersedia',
        ]);

        // Jadwal 7: Eko Prasetyo (driver_id=4) - L300 (kendaraan_id=9) - besok
        Jadwal::create([
            'driver_id' => 4,
            'kendaraan_id' => 9,
            'tanggal' => $besok,
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '17:00',
            'status' => 'tidak_tersedia',
        ]);

        // Jadwal 8: Fahmi Hidayat (driver_id=5) - Brio (kendaraan_id=6) - besok
        Jadwal::create([
            'driver_id' => 5,
            'kendaraan_id' => 6,
            'tanggal' => $besok,
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '17:00',
            'status' => 'tidak_tersedia',
        ]);
    }
}
