<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\Jadwal;
use App\Models\Kendaraan;
use Illuminate\Database\Eloquent\Factories\Factory;

class JadwalFactory extends Factory
{
    protected $model = Jadwal::class;

    public function definition(): array
    {
        return [
            'driver_id' => Driver::factory(),
            'kendaraan_id' => Kendaraan::factory(),
            'tanggal' => fake()->dateTimeBetween('today', '+30 days')->format('Y-m-d'),
            'waktu_mulai' => fake()->randomElement(['08:00', '09:00', '10:00', '13:00']),
            'waktu_selesai' => '17:00',
            'status' => 'tersedia',
        ];
    }
}