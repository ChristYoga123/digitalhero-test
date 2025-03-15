<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Service extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $with = 'media';

    public function setNamaAttribute($value)
    {
        $this->attributes['nama'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isBookedByCurrentUser($tanggal): bool
    {
        return Booking::where('service_id', $this->id)
            ->whereUserId(Auth::id())
            ->whereTanggalBooking($tanggal)
            ->whereIsAktif(true)
            ->exists();
    }

    public function isSlotAvailable(): bool
    {
        return $this->loadCount('bookings')->bookings_count < $this->slot;
    }
}
