<?php

namespace App\Models;

use App\Enums\JenisSIM;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Driver extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_driver',
        'no_telp',
        'alamat',
        'sim',
        'tarif_per_hari',
        'status',
        'foto',
    ];

    protected $casts = [
        'tarif_per_hari' => 'decimal:2',
        'sim' => JenisSIM::class,
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function jadwals(): HasMany
    {
        return $this->hasMany(Jadwal::class);
    }
}
