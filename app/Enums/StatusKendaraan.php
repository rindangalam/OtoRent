<?php

namespace App\Enums;

enum StatusKendaraan: string
{
    case Tersedia = 'tersedia';
    case Disewa = 'disewa';
    case Service = 'service';

    public function label(): string
    {
        return match ($this) {
            self::Tersedia => 'Tersedia',
            self::Disewa => 'Disewa',
            self::Service => 'Servis',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Tersedia => 'green',
            self::Disewa => 'blue',
            self::Service => 'yellow',
        };
    }
}
