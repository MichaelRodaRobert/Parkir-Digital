<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'parking_slot_id',
        'waktu_mulai',
        'waktu_selesai',
        'total_harga', // 👈 Dipastikan ada di fillable
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parkingSlot()
    {
        return $this->belongsTo(ParkingSlot::class, 'parking_slot_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
