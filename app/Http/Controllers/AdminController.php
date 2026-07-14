<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ParkingSlot;
use App\Models\Booking;
use App\Models\Payment;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::where('role', 'user')->count();
        $pendingUsers = User::where('role', 'user')
            ->where(function($q) {
                $q->where('status_pendaftaran', 'pending')
                  ->orWhereNull('status_pendaftaran');
            })->count();

        $totalSlots = ParkingSlot::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $pendingPayments = Payment::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'pendingUsers',
            'totalSlots',
            'pendingBookings',
            'pendingPayments'
        ));
    }

    public function users()
    {
        $users = User::where('role', 'user')->latest()->get();
        return view('admin.users', compact('users'));
    }

    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        $user->status_pendaftaran = 'disetujui';
        $user->save();

        return redirect()->route('admin.users')->with('success', 'Pendaftaran user ' . $user->name . ' berhasil diterima!');
    }

    public function rejectUser($id)
    {
        $user = User::findOrFail($id);
        $user->status_pendaftaran = 'ditolak';
        $user->save();

        return redirect()->route('admin.users')->with('success', 'Pendaftaran user ' . $user->name . ' telah ditolak.');
    }

    public function bookings()
    {
        $bookings = Booking::with(['user', 'parkingSlot'])->latest()->get();
        return view('admin.bookings', compact('bookings'));
    }

    public function approveBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'disetujui']);

        if ($booking->parkingSlot) {
            $slot = $booking->parkingSlot;
            $slot->status = 'terisi';
            $slot->save();
        }

        return redirect()->back()->with('success', 'Booking berhasil disetujui!');
    }

    public function rejectBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'ditolak']);

        return redirect()->back()->with('success', 'Booking telah ditolak.');
    }

    // 🔹 TAMBAHKAN METHOD UNTUK VERIFIKASI PEMBAYARAN DI BAWAH INI 🔹

    /**
     * Menampilkan Halaman Verifikasi Pembayaran Admin
     */
    public function payments()
    {
        // Ambil data pembayaran beserta relasi booking, user, dan slot parkirnya
        $payments = Payment::with(['booking.user', 'booking.parkingSlot'])->latest()->get();

        // Catatan: Jika nama file blade kamu admin/payments_history.blade.php, sesuaikan jadi 'admin.payments_history'
        return view('admin.payments', compact('payments'));
    }

    /**
     * Menyetujui Pembayaran User
     */
    public function approvePayment($id)
    {
        $payment = Payment::findOrFail($id);

        // Simpan status sebagai 'disetujui'
        $payment->status = 'disetujui';
        $payment->save();

        return redirect()->back()->with('success', 'Pembayaran berhasil disetujui!');
    }

    public function rejectPayment($id)
    {
        $payment = Payment::findOrFail($id);

        // Simpan status sebagai 'ditolak'
        $payment->status = 'ditolak';
        $payment->save();

        return redirect()->back()->with('success', 'Pembayaran telah ditolak.');
    }
}
