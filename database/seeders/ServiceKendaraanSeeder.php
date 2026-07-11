<?php

namespace Database\Seeders;

use App\Models\ServiceKendaraan;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceKendaraanSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Service 1: Isuzu Elf (kendaraan_id=10) - rutin
        // 8 Jul 2026, sedang_dikerjakan
        ServiceKendaraan::create([
            'kendaraan_id' => 10,
            'jenis_service' => 'rutin',
            'deskripsi' => 'Ganti oli mesin & filter',
            'biaya' => 500000,
            'tanggal_service' => Carbon::parse('2026-07-08'),
            'estimasi_selesai' => Carbon::parse('2026-07-10'),
            'status' => 'sedang_dikerjakan',
        ]);

        // Service 2: Mitsubishi L300 (kendaraan_id=9) - perbaikan
        // 6 Jul 2026, selesai
        ServiceKendaraan::create([
            'kendaraan_id' => 9,
            'jenis_service' => 'perbaikan',
            'deskripsi' => 'Ganti kampas rem depan & belakang',
            'biaya' => 750000,
            'tanggal_service' => Carbon::parse('2026-07-06'),
            'estimasi_selesai' => Carbon::parse('2026-07-06'),
            'status' => 'selesai',
        ]);

        // Service 3: Toyota Innova (kendaraan_id=3) - rutin
        // 12 Jul 2026, dijadwalkan
        ServiceKendaraan::create([
            'kendaraan_id' => 3,
            'jenis_service' => 'rutin',
            'deskripsi' => 'Service berkala 10.000km',
            'biaya' => 800000,
            'tanggal_service' => Carbon::parse('2026-07-12'),
            'estimasi_selesai' => Carbon::parse('2026-07-12'),
            'status' => 'dijadwalkan',
        ]);
    }
}
