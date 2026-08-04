<?php

namespace Database\Factories;

use App\Enums\StatusBooking;
use App\Models\Booking;
use App\Models\Driver;
use App\Models\Kendaraan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        $mulai = fake()->dateTimeBetween('today', '+14 days');
        $selesai = (clone $mulai)->modify('+' . fake()->numberBetween(1, 7) . ' days');
        $durasi = $mulai->diff($selesai)->days + 1;

        return [
            'user_id' => User::factory(),
            'kendaraan_id' => Kendaraan::factory(),
            'tipe_sewa' => fake()->randomElement(['driver', 'lepas_kunci']),
            'metode_antar' => 'jemput_sendiri',
            'ongkos_antar' => 0,
            'driver_id' => null,
            'tanggal_mulai' => $mulai,
            'tanggal_selesai' => $selesai,
            'lokasi_jemput' => fake()->address(),
            'lokasi_tujuan' => fake()->optional()->city(),
            'durasi_hari' => $durasi,
            'total_kendaraan' => 500000 * $durasi,
            'total_driver' => 0,
            'grand_total' => 500000 * $durasi,
            'status' => StatusBooking::Pending,
            'catatan' => fake()->optional()->sentence(),
        ];
    }

    public function pakaiDriver(): static
    {
        return $this->state(function (array $attributes) {
            $durasi = $attributes['durasi_hari'] ?? 1;

            return [
                'tipe_sewa' => 'driver',
                'driver_id' => Driver::factory(),
                'total_driver' => 200000 * $durasi,
                'grand_total' => $attributes['total_kendaraan'] + 200000 * $durasi,
            ];
        });
    }

    public function confirmed(): static
    {
        return $this->state(fn () => ['status' => StatusBooking::Confirmed]);
    }

    public function ongoing(): static
    {
        return $this->state(fn () => ['status' => StatusBooking::Ongoing]);
    }

    public function completed(): static
    {
        return $this->state(fn () => ['status' => StatusBooking::Completed]);
    }
}