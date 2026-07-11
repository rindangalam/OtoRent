<?php

namespace App\Enums;

enum MetodePembayaran: string
{
    case TransferManual = 'transfer_manual';
    case QRIS = 'qris';
    case VA = 'va';
    case Cash = 'cash';

    public function label(): string
    {
        return match ($this) {
            self::TransferManual => 'Transfer Manual',
            self::QRIS => 'QRIS',
            self::VA => 'Virtual Account',
            self::Cash => 'Cash',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::TransferManual => 'blue',
            self::QRIS => 'green',
            self::VA => 'indigo',
            self::Cash => 'yellow',
        };
    }
}
