<?php

namespace Database\Seeders;

use App\Models\Kendaraan;
use App\Models\ServiceKendaraan;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceKendaraanSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $today = Carbon::today();

        $data = [
            // [plat kendaraan, jenis_service, deskripsi, biaya, hari mulai service, durasi pengerjaan (hari), status]
            ['B 0123 LM', 'rutin', 'Ganti oli mesin & filter udara', 500000, -1, 2, 'sedang_dikerjakan'],
            ['B 5678 GH', 'rutin', 'Service berkala 10.000 km, cek rem & suspensi', 800000, -2, 1, 'selesai'],
            ['B 3456 EF', 'perbaikan', 'Ganti kampas rem depan & belakang', 750000, -21, 1, 'selesai'],
            ['B 1234 CD', 'rutin', 'Service berkala 5.000 km', 450000, -45, 1, 'selesai'],
            ['B 8901 JK', 'rutin', 'Service berkala 30.000 km', 850000, 3, 1, 'dijadwalkan'],
            ['B 2345 DE', 'rutin', 'Cek AC & ganti filter kabin', 400000, 6, 1, 'dijadwalkan'],
        ];

        foreach ($data as [$plat, $jenis, $deskripsi, $biaya, $hariMulai, $durasi, $status]) {
            $kendaraan = Kendaraan::where('plat_nomor', $plat)->first();
            if (!$kendaraan) {
                continue;
            }

            $tanggalService = $today->copy()->addDays($hariMulai);

            ServiceKendaraan::updateOrCreate(
                [
                    'kendaraan_id' => $kendaraan->id,
                    'tanggal_service' => $tanggalService,
                ],
                [
                    'jenis_service' => $jenis,
                    'deskripsi' => $deskripsi,
                    'biaya' => $biaya,
                    'estimasi_selesai' => $tanggalService->copy()->addDays($durasi),
                    'status' => $status,
                ]
            );
        }
    }
}