<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ParkingSlot;
use App\Models\Booking;
use App\Models\Payment;

class UserController extends Controller
{
    /**
     * Halaman Dashboard Utama User
     */
    public function index()
    {
        $userId = Auth::id();

        // 1. Mengambil Slot Parkir yang Tersedia untuk Pilihan Form
        $slots = ParkingSlot::where(function($q) {
            $q->where('status', 'tersedia')
              ->orWhere('status', 'Tersedia')
              ->orWhereNull('status');
        })->get();

        // 2. Slot Parkir Saya: Tampilkan SEMUA booking yang sudah disetujui Admin
        $approvedBookings = Booking::with(['parkingSlot', 'payment'])
            ->where('user_id', $userId)
            ->where('status', 'disetujui')
            ->latest()
            ->get();

        // 3. Tabel Pengajuan: Booking yang belum lunas
        $myBookings = Booking::with(['parkingSlot', 'payment'])
            ->where('user_id', $userId)
            ->whereDoesntHave('payment', function($q) {
                $q->where('status', 'valid');
            })
            ->latest()
            ->get();

        return view('user.dashboard', compact('slots', 'approvedBookings', 'myBookings'));
    }

    /**
     * Proses Pemesanan / Booking Slot Parkir
     */
    public function storeBooking(Request $request)
    {
        $request->validate([
            'parking_slot_id' => 'required|exists:parking_slots,id',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
        ]);

        Booking::create([
            'user_id' => Auth::id(),
            'parking_slot_id' => $request->parking_slot_id,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Pengajuan booking berhasil dikirim! Menunggu persetujuan admin.');
    }

    /**
     * Proses Kirim Pembayaran Booking
     */
    public function storePayment(Request $request, $bookingId)
    {
        $booking = Booking::where('user_id', Auth::id())->findOrFail($bookingId);

        // Cek apakah sudah ada pembayaran
        if (!$booking->payment) {
            Payment::create([
                'booking_id' => $booking->id,
                'status' => 'pending',
                'metode_pembayaran' => 'Transfer',
            ]);
        }

        return redirect()->back()->with('success', 'Konfirmasi pembayaran berhasil dikirim! Menunggu verifikasi admin.');
    }

    /**
     * Halaman Riwayat Lunas
     */
    public function paymentHistory()
    {
        $userId = Auth::id();

        // Mengambil semua booking milik user yang pembayaran-nya sudah Valid / Lunas
        $paidBookings = Booking::with(['parkingSlot', 'payment'])
            ->where('user_id', $userId)
            ->whereHas('payment', function($q) {
                $q->where('status', 'valid');
            })
            ->latest()
            ->get();

        return view('user.history', compact('paidBookings'));
    }
}
