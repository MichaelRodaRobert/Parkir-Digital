<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ParkingSlot;
use App\Models\Booking;
use App\Models\Payment;

class AdminController extends Controller
{
    /**
     * Display the Admin Dashboard
     */
    public function index()
    {
        // Mengambil data ringkasan untuk statistik dashboard admin
        $totalUsers = User::where('role', 'user')->count();
        $totalSlots = ParkingSlot::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $pendingPayments = Payment::where('status', 'pending')->count();

        return view('admin.dashboard', compact('totalUsers', 'totalSlots', 'pendingBookings', 'pendingPayments'));
    }

    /**
     * Halaman Verifikasi User
     */
    public function users()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.users', compact('users'));
    }

    /**
     * Halaman Verifikasi Booking
     */
    public function bookings()
    {
        $bookings = Booking::with(['user', 'parkingSlot'])->latest()->get();
        return view('admin.bookings', compact('bookings'));
    }

    /**
     * Halaman Verifikasi Pembayaran
     */
    public function payments()
    {
        $payments = Payment::with(['booking.user', 'booking.parkingSlot'])->latest()->get();
        return view('admin.payments', compact('payments'));
    }

    /**
     * Approve Pendaftaran User
     */
    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status_pendaftaran' => 'aktif']);

        return redirect()->back()->with('success', 'User berhasil diverifikasi/disetujui.');
    }

    /**
     * Approve Booking
     */
    public function approveBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'disetujui']);

        return redirect()->back()->with('success', 'Booking berhasil disetujui.');
    }

    /**
     * Reject Booking
     */
    public function rejectBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'ditolak']);

        return redirect()->back()->with('success', 'Booking berhasil ditolak.');
    }

    /**
     * Approve Pembayaran
     */
    public function approvePayment($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update(['status' => 'valid']);

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi valid.');
    }
}
