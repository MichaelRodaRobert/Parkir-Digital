<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi ke Model User (Setiap Booking milik 1 User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Model ParkingSlot
    public function parkingSlot()
    {
        return $this->belongsTo(ParkingSlot::class);
    }

    // Relasi ke Model Payment
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
