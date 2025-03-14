<?php

namespace App\Enums\Booking;

enum StatusEnum: string
{
    case MENUNGGU = 'Menunggu';
    case SUKSES = 'Sukses';
    case BATAL = 'Batal';

    public function label(): string
    {
        return match ($this) {
            self::MENUNGGU => 'Menunggu',
            self::SUKSES => 'Sukses',
            self::BATAL => 'Batal',
        };
    }
}
