<?php

namespace App\Contracts;

use App\Models\Booking;

interface PaymentInterface
{
    public function pay(Booking $transaksi): string;
}
