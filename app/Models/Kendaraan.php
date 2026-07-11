<?php

namespace App\Models;

use App\Enums\JenisKendaraan;
use App\Enums\StatusKendaraan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kendaraan extends Model
{
    protected $table = 'kendaraans';

    protected $fillable = [
        'nama_kendaraan',
        'plat_nomor',
        'jenis',
        'warna',
        'tahun',
        'kapasitas',
        'harga_sewa_per_hari',
        'gambar',
        'deskripsi',
        'status',
    ];

    protected $casts = [
        'tahun' => 'integer',
        'kapasitas' => 'integer',
        'harga_sewa_per_hari' => 'decimal:2',
        'status' => StatusKendaraan::class,
        'jenis' => JenisKendaraan::class,
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function jadwals(): HasMany
    {
        return $this->hasMany(Jadwal::class);
    }

    public function serviceKendaraans(): HasMany
    {
        return $this->hasMany(ServiceKendaraan::class);
    }
}
