<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PembayaranSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $metodes = ['transfer_manual', 'qris', 'va'];

        Booking::with(['kendaraan'])->orderBy('id')->each(function (Booking $booking, $index) use ($metodes) {
            // Booking dibatalkan tidak memiliki pembayaran
            if ($booking->status->value === 'cancelled') {
                return;
            }

            $lunas = in_array($booking->status->value, ['confirmed', 'ongoing', 'completed']);
            $menunggu = $booking->status->value === 'pending' && $index % 2 === 1;

            $status = $lunas
                ? 'lunas'
                : ($menunggu ? 'menunggu_verifikasi' : 'belum_bayar');

            $tanggalBayar = $lunas
                ? $booking->tanggal_mulai->copy()->subDay()->setTime(10, 30)
                : ($menunggu ? now()->subHour(2) : null);

            Pembayaran::updateOrCreate(
                ['booking_id' => $booking->id],
                [
                    'metode' => $metodes[$index % count($metodes)],
                    'jumlah_bayar' => $booking->grand_total,
                    'status' => $status,
                    'tanggal_bayar' => $tanggalBayar ? Carbon::parse($tanggalBayar) : null,
                ]
            );
        });
    }
}