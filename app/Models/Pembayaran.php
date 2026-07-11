<?php

namespace App\Models;

use App\Enums\MetodePembayaran;
use App\Enums\StatusPembayaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $fillable = [
        'booking_id',
        'metode',
        'jumlah_bayar',
        'status',
        'bukti_bayar',
        'catatan_admin',
        'tanggal_bayar',
    ];

    protected $casts = [
        'jumlah_bayar' => 'decimal:2',
        'tanggal_bayar' => 'datetime',
        'status' => StatusPembayaran::class,
        'metode' => MetodePembayaran::class,
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
