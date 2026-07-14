<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'jumlah_bayar',
        'metode_pembayaran',
        'bukti_pembayaran', // Boleh null / kosong
        'status',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
