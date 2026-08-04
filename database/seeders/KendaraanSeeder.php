<?php

namespace Database\Seeders;

use App\Models\Kendaraan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KendaraanSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $kendaraan = [
            [
                'nama_kendaraan' => 'Toyota Avanza 1.5 G', 'plat_nomor' => 'B 1234 CD',
                'jenis' => 'mpv', 'warna' => 'Putih', 'tahun' => 2023, 'kapasitas' => 7,
                'harga_sewa_per_hari' => 350000, 'gambar' => 'kendaraan/avanza.jpg',
                'deskripsi' => 'Toyota Avanza 1.5 G varian terbaru dengan fitur lengkap, nyaman untuk perjalanan keluarga.',
                'status' => 'tersedia',
            ],
            [
                'nama_kendaraan' => 'Daihatsu Xenia 1.5 R', 'plat_nomor' => 'B 2345 DE',
                'jenis' => 'mpv', 'warna' => 'Silver', 'tahun' => 2023, 'kapasitas' => 7,
                'harga_sewa_per_hari' => 350000, 'gambar' => 'kendaraan/xenia.jpg',
                'deskripsi' => 'Daihatsu Xenia 1.5 R dengan kabin luas dan irit bahan bakar, cocok untuk perjalanan jauh.',
                'status' => 'tersedia',
            ],
            [
                'nama_kendaraan' => 'Toyota Innova Reborn 2.4', 'plat_nomor' => 'B 3456 EF',
                'jenis' => 'mpv', 'warna' => 'Hitam', 'tahun' => 2022, 'kapasitas' => 7,
                'harga_sewa_per_hari' => 550000, 'gambar' => 'kendaraan/innova.jpg',
                'deskripsi' => 'Toyota Innova Reborn 2.4 G varian diesel, kendaraan legendaris untuk perjalanan bisnis dan keluarga.',
                'status' => 'tersedia',
            ],
            [
                'nama_kendaraan' => 'Mitsubishi Pajero Sport Dakar', 'plat_nomor' => 'B 4567 FG',
                'jenis' => 'suv', 'warna' => 'Putih', 'tahun' => 2023, 'kapasitas' => 7,
                'harga_sewa_per_hari' => 800000, 'gambar' => 'kendaraan/pajero.jpg',
                'deskripsi' => 'Mitsubishi Pajero Sport Dakar 4x2, SUV mewah dengan performa tangguh di segala medan.',
                'status' => 'tersedia',
            ],
            [
                'nama_kendaraan' => 'Toyota Fortuner 2.4 VRZ', 'plat_nomor' => 'B 5678 GH',
                'jenis' => 'suv', 'warna' => 'Hitam', 'tahun' => 2023, 'kapasitas' => 7,
                'harga_sewa_per_hari' => 900000, 'gambar' => 'kendaraan/fortuner.jpg',
                'deskripsi' => 'Toyota Fortuner 2.4 VRZ diesel, SUV premium dengan kenyamanan maksimal.',
                'status' => 'disewa',
            ],
            [
                'nama_kendaraan' => 'Honda Brio RS', 'plat_nomor' => 'B 6789 HI',
                'jenis' => 'sedan', 'warna' => 'Merah', 'tahun' => 2023, 'kapasitas' => 5,
                'harga_sewa_per_hari' => 300000, 'gambar' => 'kendaraan/brio.jpg',
                'deskripsi' => 'Honda Brio RS varian sporty, lincah di perkotaan dan irit bahan bakar.',
                'status' => 'tersedia',
            ],
            [
                'nama_kendaraan' => 'Toyota Camry 2.5 V', 'plat_nomor' => 'B 7890 IJ',
                'jenis' => 'sedan', 'warna' => 'Putih', 'tahun' => 2022, 'kapasitas' => 5,
                'harga_sewa_per_hari' => 750000, 'gambar' => 'kendaraan/camry.jpg',
                'deskripsi' => 'Toyota Camry 2.5 V, sedan eksekutif dengan interior mewah dan performa halus.',
                'status' => 'tersedia',
            ],
            [
                'nama_kendaraan' => 'Suzuki Carry 1.5', 'plat_nomor' => 'B 8901 JK',
                'jenis' => 'minibus', 'warna' => 'Putih', 'tahun' => 2022, 'kapasitas' => 12,
                'harga_sewa_per_hari' => 450000, 'gambar' => 'kendaraan/carry.jpg',
                'deskripsi' => 'Suzuki Carry 1.5, kendaraan serbaguna kapasitas besar untuk angkutan orang atau barang.',
                'status' => 'tersedia',
            ],
            [
                'nama_kendaraan' => 'Mitsubishi L300', 'plat_nomor' => 'B 9012 KL',
                'jenis' => 'truk', 'warna' => 'Putih', 'tahun' => 2021, 'kapasitas' => 3,
                'harga_sewa_per_hari' => 500000, 'gambar' => 'kendaraan/l300.jpg',
                'deskripsi' => 'Mitsubishi L300 pikup, handal untuk angkutan barang dengan bak luas.',
                'status' => 'disewa',
            ],
            [
                'nama_kendaraan' => 'Isuzu Elf NLR 2.5', 'plat_nomor' => 'B 0123 LM',
                'jenis' => 'minibus', 'warna' => 'Putih', 'tahun' => 2022, 'kapasitas' => 16,
                'harga_sewa_per_hari' => 600000, 'gambar' => 'kendaraan/elf.jpg',
                'deskripsi' => 'Isuzu Elf NLR 2.5, kendaraan angkutan kapasitas 16 kursi, cocok untuk rombongan.',
                'status' => 'service',
            ],
            [
                'nama_kendaraan' => 'Toyota Alphard 3.5 V', 'plat_nomor' => 'B 1234 KL',
                'jenis' => 'mpv', 'warna' => 'Hitam', 'tahun' => 2023, 'kapasitas' => 7,
                'harga_sewa_per_hari' => 2500000, 'gambar' => 'kendaraan/alphard.jpg',
                'deskripsi' => 'Toyota Alphard 3.5 V, MPV mewah kelas eksekutif dengan kenyamanan setingkat limusin.',
                'status' => 'tersedia',
            ],
            [
                'nama_kendaraan' => 'Hyundai Staria 2.2 CRDi', 'plat_nomor' => 'B 2345 LM',
                'jenis' => 'mpv', 'warna' => 'Silver', 'tahun' => 2024, 'kapasitas' => 9,
                'harga_sewa_per_hari' => 1800000, 'gambar' => 'kendaraan/staria.jpg',
                'deskripsi' => 'Hyundai Staria 2.2 CRDi Premium, MPV futuristik dengan kabin lega untuk rombongan premium.',
                'status' => 'tersedia',
            ],
        ];

        foreach ($kendaraan as $item) {
            Kendaraan::updateOrCreate(
                ['plat_nomor' => $item['plat_nomor']],
                $item
            );
        }
    }
}