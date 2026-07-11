<?php

namespace Database\Seeders;

use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PembayaranSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Pembayaran 1: Booking #1 (Andi - Avanza) - pending
        // menunggu_verifikasi, belum bayar
        Pembayaran::create([
            'booking_id' => 1,
            'metode' => 'transfer_manual',
            'jumlah_bayar' => 1500000,
            'status' => 'menunggu_verifikasi',
            'tanggal_bayar' => null,
        ]);

        // Pembayaran 2: Booking #2 (Budi S - Innova) - completed
        // lunas, dibayar 4 Jul 2026
        Pembayaran::create([
            'booking_id' => 2,
            'metode' => 'transfer_manual',
            'jumlah_bayar' => 2100000,
            'status' => 'lunas',
            'tanggal_bayar' => Carbon::parse('2026-07-04'),
        ]);

        // Pembayaran 3: Booking #3 (Citra - Pajero) - confirmed
        // lunas, dibayar 14 Jul 2026
        Pembayaran::create([
            'booking_id' => 3,
            'metode' => 'transfer_manual',
            'jumlah_bayar' => 2400000,
            'status' => 'lunas',
            'tanggal_bayar' => Carbon::parse('2026-07-14'),
        ]);

        // Pembayaran 4: Booking #4 (Andi - Fortuner) - pending
        // belum_bayar
        Pembayaran::create([
            'booking_id' => 4,
            'metode' => 'transfer_manual',
            'jumlah_bayar' => 2700000,
            'status' => 'belum_bayar',
            'tanggal_bayar' => null,
        ]);

        // Pembayaran 5: Booking #5 (Budi S - Brio) - ongoing
        // lunas, dibayar 31 Jul 2026
        Pembayaran::create([
            'booking_id' => 5,
            'metode' => 'transfer_manual',
            'jumlah_bayar' => 1000000,
            'status' => 'lunas',
            'tanggal_bayar' => Carbon::parse('2026-07-31'),
        ]);
    }
}
