<?php

namespace Database\Factories;

use App\Enums\JenisKendaraan;
use App\Enums\StatusKendaraan;
use App\Models\Kendaraan;
use Illuminate\Database\Eloquent\Factories\Factory;

class KendaraanFactory extends Factory
{
    protected $model = Kendaraan::class;

    public function definition(): array
    {
        return [
            'nama_kendaraan' => fake()->randomElement([
                'Toyota Avanza', 'Honda Brio', 'Toyota Innova', 'Mitsubishi Pajero',
                'Toyota Fortuner', 'Toyota Alphard', 'Honda HR-V', 'Suzuki Ertiga',
            ]),
            'plat_nomor' => fake()->unique()->regexify('[A-Z]{1,2}-[0-9]{1,4}-[A-Z]{1,3}'),
            'jenis' => JenisKendaraan::cases()[fake()->numberBetween(0, count(JenisKendaraan::cases()) - 1)],
            'warna' => fake()->randomElement(['Hitam', 'Putih', 'Silver', 'Abu-abu', 'Merah', 'Biru']),
            'tahun' => fake()->numberBetween(2018, 2026),
            'kapasitas' => fake()->numberBetween(4, 8),
            'harga_sewa_per_hari' => fake()->numberBetween(250000, 2500000),
            'gambar' => fake()->word() . '.jpg',
            'status' => StatusKendaraan::Tersedia,
            'deskripsi' => fake()->sentence(8),
        ];
    }

    public function tersedia(): static
    {
        return $this->state(fn () => ['status' => StatusKendaraan::Tersedia]);
    }

    public function disewa(): static
    {
        return $this->state(fn () => ['status' => StatusKendaraan::Disewa]);
    }
}