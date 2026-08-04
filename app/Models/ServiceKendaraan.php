<?php

namespace App\Models;

use App\Enums\JenisService;
use App\Enums\StatusService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceKendaraan extends Model
{
    use HasFactory;
    protected $fillable = [
        'kendaraan_id',
        'jenis_service',
        'deskripsi',
        'biaya',
        'tanggal_service',
        'estimasi_selesai',
        'status',
    ];

    protected $casts = [
        'biaya' => 'decimal:2',
        'tanggal_service' => 'date',
        'estimasi_selesai' => 'date',
        'status' => StatusService::class,
        'jenis_service' => JenisService::class,
    ];

    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(Kendaraan::class);
    }
}
