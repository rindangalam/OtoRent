<?php

namespace Database\Factories;

use App\Enums\JenisService;
use App\Enums\StatusService;
use App\Models\Kendaraan;
use App\Models\ServiceKendaraan;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceKendaraanFactory extends Factory
{
    protected $model = ServiceKendaraan::class;

    public function definition(): array
    {
        $tanggal = fake()->dateTimeBetween('-30 days', '+30 days');

        return [
            'kendaraan_id' => Kendaraan::factory(),
            'jenis_service' => fake()->randomElement(JenisService::cases()),
            'deskripsi' => fake()->sentence(8),
            'biaya' => fake()->numberBetween(200000, 3000000),
            'tanggal_service' => $tanggal,
            'estimasi_selesai' => (clone $tanggal)->modify('+' . fake()->numberBetween(1, 7) . ' days'),
            'status' => StatusService::Dijadwalkan,
        ];
    }

    public function selesai(): static
    {
        return $this->state(fn () => ['status' => StatusService::Selesai]);
    }
}