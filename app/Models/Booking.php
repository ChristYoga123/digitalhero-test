<?php

namespace App\Models;

use App\Enums\Booking\StatusEnum;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

    protected $casts = [
        'tanggal_booking' => 'date',
        'status' => StatusEnum::class,
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
