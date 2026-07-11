<?php

namespace App\Enums;

enum StatusBooking: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Ongoing = 'ongoing';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Menunggu',
            self::Confirmed => 'Dikonfirmasi',
            self::Ongoing => 'Berlangsung',
            self::Completed => 'Selesai',
            self::Cancelled => 'Dibatalkan',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'yellow',
            self::Confirmed => 'blue',
            self::Ongoing => 'indigo',
            self::Completed => 'green',
            self::Cancelled => 'red',
        };
    }
}
