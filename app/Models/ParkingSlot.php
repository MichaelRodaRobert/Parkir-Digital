<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingSlot extends Model
{
    use HasFactory;

    protected $table = 'parking_slots';

    protected $fillable = [
        'nama_slot',    // atau 'nomor_slot' / 'kode_slot' sesuai database kamu
        'status',       // 👈 Tambahkan baris ini!
        'harga',
    ];

    /**
     * Relasi ke Booking
     */
    public function approveBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'disetujui']);

        // Update tanpa mass assignment
        if ($booking->parkingSlot) {
            $slot = $booking->parkingSlot;
            $slot->status = 'terisi';
            $slot->save();
        }

        return redirect()->back()->with('success', 'Booking berhasil disetujui!');
    }
}
