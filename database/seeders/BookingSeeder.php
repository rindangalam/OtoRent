<?php

namespace Database\Seeders;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Booking 1: Andi (user_id=3) - Avanza (kendaraan_id=1) - Budi (driver_id=1)
        // Pakai Driver, 3 hari, harga 350000/hari, tarif driver 150000/hari
        Booking::create([
            'user_id' => 3,
            'kendaraan_id' => 1,
            'tipe_sewa' => 'driver',
            'metode_antar' => null,
            'ongkos_antar' => 0,
            'driver_id' => 1,
            'tanggal_mulai' => Carbon::parse('2026-07-10'),
            'tanggal_selesai' => Carbon::parse('2026-07-12'),
            'lokasi_jemput' => 'Jl. Merdeka No. 1, Jakarta',
            'lokasi_tujuan' => 'Bandung, Jawa Barat',
            'durasi_hari' => 3,
            'total_kendaraan' => 1050000,
            'total_driver' => 450000,
            'grand_total' => 1500000,
            'status' => 'pending',
            'catatan' => 'Jemput di rumah, tujuan Bandung untuk liburan keluarga.',
        ]);

        // Booking 2: Budi S (user_id=4) - Innova (kendaraan_id=3) - Agus (driver_id=2)
        // Pakai Driver, 3 hari, harga 550000/hari, tarif driver 150000/hari
        Booking::create([
            'user_id' => 4,
            'kendaraan_id' => 3,
            'tipe_sewa' => 'driver',
            'metode_antar' => null,
            'ongkos_antar' => 0,
            'driver_id' => 2,
            'tanggal_mulai' => Carbon::parse('2026-07-05'),
            'tanggal_selesai' => Carbon::parse('2026-07-07'),
            'lokasi_jemput' => 'Jl. Sudirman No. 50, Jakarta',
            'lokasi_tujuan' => 'Yogyakarta',
            'durasi_hari' => 3,
            'total_kendaraan' => 1650000,
            'total_driver' => 450000,
            'grand_total' => 2100000,
            'status' => 'completed',
            'catatan' => 'Perjalanan dinas ke Yogyakarta.',
        ]);

        // Booking 3: Citra (user_id=5) - Pajero (kendaraan_id=4) - Lepas Kunci + Diantar
        // 3 hari, harga 800000/hari, ongkos antar 75000
        Booking::create([
            'user_id' => 5,
            'kendaraan_id' => 4,
            'tipe_sewa' => 'lepas_kunci',
            'metode_antar' => 'diantar',
            'ongkos_antar' => 75000,
            'driver_id' => null,
            'tanggal_mulai' => Carbon::parse('2026-07-15'),
            'tanggal_selesai' => Carbon::parse('2026-07-17'),
            'lokasi_jemput' => 'Jl. Kuningan No. 10, Jakarta',
            'lokasi_tujuan' => null,
            'durasi_hari' => 3,
            'total_kendaraan' => 2400000,
            'total_driver' => 0,
            'grand_total' => 2475000,
            'status' => 'confirmed',
            'catatan' => 'Liburan ke Puncak, lepas kunci.',
        ]);

        // Booking 4: Andi (user_id=3) - Fortuner (kendaraan_id=5) - Lepas Kunci + Jemput Sendiri
        // 3 hari, harga 900000/hari
        Booking::create([
            'user_id' => 3,
            'kendaraan_id' => 5,
            'tipe_sewa' => 'lepas_kunci',
            'metode_antar' => 'jemput_sendiri',
            'ongkos_antar' => 0,
            'driver_id' => null,
            'tanggal_mulai' => Carbon::parse('2026-07-20'),
            'tanggal_selesai' => Carbon::parse('2026-07-22'),
            'lokasi_jemput' => 'Jl. Rental OtoRent, Jakarta',
            'lokasi_tujuan' => null,
            'durasi_hari' => 3,
            'total_kendaraan' => 2700000,
            'total_driver' => 0,
            'grand_total' => 2700000,
            'status' => 'pending',
            'catatan' => null,
        ]);

        // Booking 5: Budi S (user_id=4) - Brio (kendaraan_id=6) - Dedi (driver_id=3)
        // Pakai Driver, 2 hari, harga 300000/hari, tarif driver 200000/hari
        Booking::create([
            'user_id' => 4,
            'kendaraan_id' => 6,
            'tipe_sewa' => 'driver',
            'metode_antar' => null,
            'ongkos_antar' => 0,
            'driver_id' => 3,
            'tanggal_mulai' => Carbon::parse('2026-08-01'),
            'tanggal_selesai' => Carbon::parse('2026-08-02'),
            'lokasi_jemput' => 'Jl. Sudirman No. 50, Jakarta',
            'lokasi_tujuan' => 'Anyer, Banten',
            'durasi_hari' => 2,
            'total_kendaraan' => 600000,
            'total_driver' => 400000,
            'grand_total' => 1000000,
            'status' => 'ongoing',
            'catatan' => 'Liburan akhir pekan ke Anyer.',
        ]);
    }
}
