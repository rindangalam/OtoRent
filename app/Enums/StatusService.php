<?php

namespace App\Enums;

enum StatusService: string
{
    case Dijadwalkan = 'dijadwalkan';
    case SedangDikerjakan = 'sedang_dikerjakan';
    case Selesai = 'selesai';

    public function label(): string
    {
        return match ($this) {
            self::Dijadwalkan => 'Dijadwalkan',
            self::SedangDikerjakan => 'Sedang Dikerjakan',
            self::Selesai => 'Selesai',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Dijadwalkan => 'blue',
            self::SedangDikerjakan => 'yellow',
            self::Selesai => 'green',
        };
    }
}
