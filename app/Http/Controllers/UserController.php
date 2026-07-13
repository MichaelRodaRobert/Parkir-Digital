<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkingSlot;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
{
    $userId = Auth::id();

    // Slot Parkir yang tersedia untuk pilihan form
    $slots = ParkingSlot::where('status', 'tersedia')->get();

    // 1. Slot Parkir Saya: Tampilkan SEMUA booking yang sudah disetujui Admin (termasuk yang sudah lunas)
    $approvedBookings = Booking::with('parkingSlot', 'payment')
        ->where('user_id', $userId)
        ->where('status', 'disetujui')
        ->latest()
        ->get();

    // 2. Tabel Pengajuan: Hanya tampilkan booking yang MASIH PROSES (Pending / Disetujui tapi belum lunas)
    $myBookings = Booking::with('parkingSlot', 'payment')
        ->where('user_id', $userId)
        ->whereDoesntHave('payment', function($q) {
            $q->where('status', 'valid');
        })
        ->latest()
        ->get();

    return view('user.dashboard', compact('slots', 'approvedBookings', 'myBookings'));
}

    public function storeBooking(Request $request)
    {
        $request->validate([
            'parking_slot_id' => 'required|exists:parking_slots,id',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
        ]);

        // Cek Bentrok Waktu (Overlap)
        $isOverlapping = Booking::where('parking_slot_id', $request->parking_slot_id)
            ->whereIn('status', ['pending', 'disetujui'])
            ->where(function ($query) use ($request) {
                $query->where('waktu_mulai', '<', $request->waktu_selesai)
                      ->where('waktu_selesai', '>', $request->waktu_mulai);
            })
            ->exists();

        if ($isOverlapping) {
            return redirect()->back()->with('error', 'Slot parkir ini sudah dibooking pada rentang waktu tersebut. Silakan pilih slot atau waktu lain!');
        }

        Booking::create([
            'user_id' => Auth::id(),
            'parking_slot_id' => $request->parking_slot_id,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Pemesanan parkir berhasil diajukan!');
    }

    public function storePayment($booking_id)
    {
        $existingPayment = Payment::where('booking_id', $booking_id)->first();

        if (!$existingPayment) {
            Payment::create([
                'booking_id' => $booking_id,
                'jumlah_bayar' => 10000,
                'bukti_pembayaran' => '-',
                'status' => 'pending',
            ]);
        }

        return redirect()->back()->with('success', 'Pembayaran berhasil dikirim! Menunggu konfirmasi admin.');
    }

    // METHOD BARU: Menampilkan Halaman Riwayat Pembayaran yang Sudah Dibayar / Valid
    public function historyPayments()
    {
        $paidPayments = Payment::with(['booking.parkingSlot'])
            ->whereHas('booking', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->where('status', 'valid')
            ->latest()
            ->get();

        return view('user.payments_history', compact('paidPayments'));
    }
}
