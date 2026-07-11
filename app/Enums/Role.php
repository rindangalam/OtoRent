<?php

namespace App\Enums;

enum Role: string
{
    case Admin = 'admin';
    case Customer = 'customer';
    case Staff = 'staff';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::Customer => 'Pelanggan',
            self::Staff => 'Staf',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Admin => 'red',
            self::Customer => 'green',
            self::Staff => 'blue',
        };
    }
}
