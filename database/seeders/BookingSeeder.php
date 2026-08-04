<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Driver;
use App\Models\Kendaraan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $today = Carbon::today();

        $data = [
            // [email user, plat kendaraan, tipe_sewa, metode_antar, ongkos_antar, nama driver, hari mulai (-/+), durasi, status, lokasi_jemput, lokasi_tujuan, catatan]
            ['budi@example.com', 'B 1234 CD', 'driver', null, 0, 'Budi Santoso', -30, 3, 'completed', 'Jl. Merdeka No. 1, Jakarta', 'Bandung, Jawa Barat', 'Liburan keluarga ke Bandung.'],
            ['citra@example.com', 'B 4567 FG', 'lepas_kunci', 'diantar', 75000, null, -25, 2, 'completed', 'Jl. Kuningan No. 10, Jakarta', null, 'Weekend ke Puncak, mobil diantar ke rumah.'],
            ['andi@example.com', 'B 3456 EF', 'driver', null, 0, 'Agus Wijaya', -20, 3, 'completed', 'Jl. Sudirman No. 50, Jakarta', 'Yogyakarta', 'Perjalanan dinas ke Yogyakarta.'],
            ['dewi@example.com', 'B 7890 IJ', 'lepas_kunci', 'jemput_sendiri', 0, null, -14, 2, 'completed', 'Jl. Rental OtoRent, Jakarta', null, 'Acara keluarga di luar kota.'],
            ['eka@example.com', 'B 2345 DE', 'driver', null, 0, 'Dedi Kurniawan', -9, 2, 'completed', 'Jl. Gatot Subroto No. 30, Jakarta', 'Anyer, Banten', 'Liburan akhir pekan ke Anyer.'],
            ['fajar@example.com', 'B 5678 GH', 'lepas_kunci', 'jemput_sendiri', 0, null, -2, 4, 'ongoing', 'Jl. Rental OtoRent, Jakarta', null, 'Mobil untuk keperluan keluarga 4 hari.'],
            ['gilang@example.com', 'B 6789 HI', 'driver', null, 0, 'Eko Prasetyo', 2, 2, 'confirmed', 'Jl. Thamrin No. 7, Jakarta', 'Bogor, Jawa Barat', 'Jalan-jalan ke Bogor dengan driver.'],
            ['hana@example.com', 'B 1234 KL', 'lepas_kunci', 'diantar', 100000, null, 5, 1, 'confirmed', 'Hotel Grand Hyatt, Jakarta', null, 'Acara gathering keluarga, mobil diantar ke hotel.'],
            ['irfan@example.com', 'B 2345 LM', 'driver', null, 0, 'Gunawan Setiawan', 8, 3, 'pending', 'Jl. Rasuna Said No. 25, Jakarta', 'Semarang, Jawa Tengah', 'Kunjungan keluarga ke Semarang.'],
            ['andi@example.com', 'B 1234 CD', 'lepas_kunci', 'diantar', 75000, null, 12, 2, 'pending', 'Jl. Sudirman No. 50, Jakarta', null, 'Acara kantor, butuh mobil sementara.'],
            ['citra@example.com', 'B 4567 FG', 'driver', null, 0, 'Hendra Wijaya', 15, 2, 'confirmed', 'Jl. Kuningan No. 10, Jakarta', 'Karawang, Jawa Barat', 'Mengunjungi pameran di Karawang.'],
            ['dewi@example.com', 'B 8901 JK', 'lepas_kunci', 'jemput_sendiri', 0, null, 18, 3, 'confirmed', 'Jl. Rental OtoRent, Jakarta', null, 'Keperluan pindahan sebagian barang.'],
        ];

        foreach ($data as [$email, $plat, $tipe, $metode, $ongkos, $namaDriver, $hariMulai, $durasi, $status, $lokasiJemput, $lokasiTujuan, $catatan]) {
            $user = User::where('email', $email)->first();
            $kendaraan = Kendaraan::where('plat_nomor', $plat)->first();
            if (!$user || !$kendaraan) {
                continue;
            }

            $driver = $namaDriver ? Driver::where('nama_driver', $namaDriver)->first() : null;

            $totalKendaraan = $kendaraan->harga_sewa_per_hari * $durasi;
            $totalDriver = $driver ? $driver->tarif_per_hari * $durasi : 0;
            $grandTotal = $totalKendaraan + $totalDriver + $ongkos;

            Booking::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'kendaraan_id' => $kendaraan->id,
                    'tanggal_mulai' => $today->copy()->addDays($hariMulai),
                ],
                [
                    'tipe_sewa' => $tipe,
                    'metode_antar' => $metode,
                    'ongkos_antar' => $ongkos,
                    'driver_id' => $driver?->id,
                    'tanggal_selesai' => $today->copy()->addDays($hariMulai)->addDays($durasi - 1),
                    'lokasi_jemput' => $lokasiJemput,
                    'lokasi_tujuan' => $lokasiTujuan,
                    'durasi_hari' => $durasi,
                    'total_kendaraan' => $totalKendaraan,
                    'total_driver' => $totalDriver,
                    'grand_total' => $grandTotal,
                    'status' => $status,
                    'catatan' => $catatan,
                ]
            );
        }
    }
}