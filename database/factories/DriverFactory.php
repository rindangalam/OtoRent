<?php

namespace Database\Factories;

use App\Enums\JenisSIM;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

class DriverFactory extends Factory
{
    protected $model = Driver::class;

    public function definition(): array
    {
        return [
            'nama_driver' => fake()->name(),
            'no_telp' => fake()->numerify('08##########'),
            'alamat' => fake()->address(),
            'sim' => JenisSIM::A,
            'tarif_per_hari' => fake()->numberBetween(150000, 400000),
            'status' => 'aktif',
        ];
    }

    public function aktif(): static
    {
        return $this->state(fn () => ['status' => 'aktif']);
    }

    public function bertugas(): static
    {
        return $this->state(fn () => ['status' => 'sedang_bertugas']);
    }
}