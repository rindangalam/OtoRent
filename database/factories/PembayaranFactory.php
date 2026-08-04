<?php

namespace Database\Factories;

use App\Enums\MetodePembayaran;
use App\Enums\StatusPembayaran;
use App\Models\Booking;
use App\Models\Pembayaran;
use Illuminate\Database\Eloquent\Factories\Factory;

class PembayaranFactory extends Factory
{
    protected $model = Pembayaran::class;

    public function definition(): array
    {
        $booking = Booking::factory()->create();
        $status = StatusPembayaran::Lunas;

        return [
            'booking_id' => $booking->id,
            'metode' => MetodePembayaran::TransferManual,
            'jumlah_bayar' => $booking->grand_total,
            'status' => $status,
            'tanggal_bayar' => now(),
        ];
    }

    public function menungguVerifikasi(): static
    {
        return $this->state(fn () => ['status' => StatusPembayaran::MenungguVerifikasi]);
    }

    public function belumBayar(): static
    {
        return $this->state(fn () => ['status' => StatusPembayaran::BelumBayar, 'tanggal_bayar' => null]);
    }
}