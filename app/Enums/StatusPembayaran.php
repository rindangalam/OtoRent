<?php

namespace App\Enums;

enum StatusPembayaran: string
{
    case BelumBayar = 'belum_bayar';
    case MenungguVerifikasi = 'menunggu_verifikasi';
    case Lunas = 'lunas';
    case Refund = 'refund';
    case Ditolak = 'ditolak';

    public function label(): string
    {
        return match ($this) {
            self::BelumBayar => 'Belum Bayar',
            self::MenungguVerifikasi => 'Menunggu Verifikasi',
            self::Lunas => 'Lunas',
            self::Refund => 'Refund',
            self::Ditolak => 'Ditolak',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::BelumBayar => 'gray',
            self::MenungguVerifikasi => 'yellow',
            self::Lunas => 'green',
            self::Refund => 'orange',
            self::Ditolak => 'red',
        };
    }
}
