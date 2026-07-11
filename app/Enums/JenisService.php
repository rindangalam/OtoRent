<?php

namespace App\Enums;

enum JenisService: string
{
    case Rutin = 'rutin';
    case Perbaikan = 'perbaikan';
    case GantiSukuCadang = 'ganti_suku_cadang';

    public function label(): string
    {
        return match ($this) {
            self::Rutin => 'Rutin',
            self::Perbaikan => 'Perbaikan',
            self::GantiSukuCadang => 'Ganti Suku Cadang',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Rutin => 'blue',
            self::Perbaikan => 'yellow',
            self::GantiSukuCadang => 'red',
        };
    }
}
