<?php

namespace App\Models;

use App\Enums\StatusBooking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'kendaraan_id',
        'tipe_sewa',
        'metode_antar',
        'ongkos_antar',
        'driver_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'lokasi_jemput',
        'lokasi_tujuan',
        'durasi_hari',
        'total_kendaraan',
        'total_driver',
        'grand_total',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'durasi_hari' => 'integer',
        'total_kendaraan' => 'decimal:2',
        'total_driver' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'ongkos_antar' => 'decimal:2',
        'status' => StatusBooking::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class);
    }
}
