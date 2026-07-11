<?php

namespace App\Enums;

enum JenisKendaraan: string
{
    case Sedan = 'sedan';
    case SUV = 'suv';
    case MPV = 'mpv';
    case Minibus = 'minibus';
    case Truk = 'truk';

    public function label(): string
    {
        return match ($this) {
            self::Sedan => 'Sedan',
            self::SUV => 'SUV',
            self::MPV => 'MPV',
            self::Minibus => 'Minibus',
            self::Truk => 'Truk',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Sedan => 'blue',
            self::SUV => 'green',
            self::MPV => 'yellow',
            self::Minibus => 'indigo',
            self::Truk => 'red',
        };
    }
}
