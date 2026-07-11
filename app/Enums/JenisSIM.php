<?php

namespace App\Enums;

enum JenisSIM: string
{
    case A = 'A';
    case B1 = 'B1';
    case B2 = 'B2';

    public function label(): string
    {
        return match ($this) {
            self::A => 'SIM A',
            self::B1 => 'SIM B1',
            self::B2 => 'SIM B2',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::A => 'blue',
            self::B1 => 'green',
            self::B2 => 'yellow',
        };
    }
}
