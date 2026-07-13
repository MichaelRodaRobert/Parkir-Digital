<?php

namespace App\Http\Controllers;

use App\Models\ParkingSlot;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth Facade

class UserController extends Controller
{
    // Halaman Dashboard Pengguna & List Pengumuman
    public function index()
    {
        $announcements = Announcement::latest()->get();
        $slots = ParkingSlot::where('status', 'tersedia')->get();
        $myBookings = Booking::with(['parkingSlot', 'payment'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.dashboard', compact('announcements', 'slots', 'myBookings'));
    }

    // Melakukan Pemesanan Slot Parkir
    public function storeBooking(Request $request)
    {
        $request->validate([
            'parking_slot_id' => 'required|exists:parking_slots,id',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
        ]);

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'parking_slot_id' => $request->parking_slot_id,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'status_pemesanan' => 'pending',
        ]);

        // Ubah status slot menjadi dipesan
        ParkingSlot::where('id', $request->parking_slot_id)->update(['status' => 'dipesan']);

        return back()->with('alert-success', 'Pemesanan slot parkir berhasil dikirim. Menunggu verifikasi admin.');
    }

    // Konfirmasi Pembayaran (Upload Gambar Bukti)
    public function storePayment(Request $request, $bookingId)
    {
        $request->validate([
            'total_bayar' => 'required|numeric',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('bukti_pembayaran')->store('payments', 'public');

        Payment::create([
            'booking_id' => $bookingId,
            'total_bayar' => $request->total_bayar,
            'bukti_pembayaran' => $path,
            'status_pembayaran' => 'pending',
        ]);

        return back()->with('alert-success', 'Konfirmasi pembayaran berhasil diunggah. Menunggu konfirmasi admin.');
    }
}
