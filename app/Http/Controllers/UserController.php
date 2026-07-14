<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkingSlot;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Menampilkan Dashboard User
     */
    public function index()
    {
        $userId = Auth::id();

        // 1. Slot parkir yang tersedia
        $availableSlots = ParkingSlot::where('status', 'tersedia')->get();

        // 2. Booking milik user yang sedang aktif
        $myBookings = Booking::with(['parkingSlot', 'payment'])
            ->where('user_id', $userId)
            ->latest()
            ->get();

        // 3. Cari booking yang SUDAH DI-ACC tapi BELUM DIBAYAR (atau pembayaran ditolak)
        $activeBookingToPay = Booking::with(['parkingSlot', 'payment'])
            ->where('user_id', $userId)
            ->where('status', 'disetujui')
            ->where(function($q) {
                $q->whereDoesntHave('payment')
                  ->orWhereHas('payment', function($p) {
                      $p->where('status', 'ditolak');
                  });
            })
            ->first();

        return view('user.dashboard', compact('availableSlots', 'myBookings', 'activeBookingToPay'));
    }

    /**
     * Menyimpan Booking Baru dengan Perhitungan Tarif Otomatis
     */
    public function storeBooking(Request $request)
    {
        // Cek status pendaftaran user
        if (Auth::user()->status_pendaftaran !== 'disetujui') {
            return redirect()->back()->with('error', 'Akun Anda belum diverifikasi oleh Admin!');
        }

        $request->validate([
            'parking_slot_id' => 'required|exists:parking_slots,id',
            'waktu_mulai'     => 'required|date',
            'waktu_selesai'   => 'required|date|after:waktu_mulai',
        ]);

        // 🧮 1. Hitung Durasi dalam Jam
        $mulai = Carbon::parse($request->waktu_mulai);
        $selesai = Carbon::parse($request->waktu_selesai);

        // Selisih jam dibulatkan ke atas (misal 1 jam 15 menit -> 2 jam)
        $durasiJam = ceil($mulai->diffInMinutes($selesai) / 60);
        if ($durasiJam < 1) {
            $durasiJam = 1;
        }

        // 💰 2. Hitung Tarif (Rp 2.000 / jam)
        $tarifPerJam = 2000;
        $totalHarga = $durasiJam * $tarifPerJam;

        // 🛑 3. Cek Batas Maksimal Per Hari (Rp 20.000 / hari)
        $jumlahHari = ceil($durasiJam / 24);
        if ($jumlahHari < 1) {
            $jumlahHari = 1;
        }

        $maxTarifPerHari = 20000;
        $maxTotalHarga = $jumlahHari * $maxTarifPerHari;

        if ($totalHarga > $maxTotalHarga) {
            $totalHarga = $maxTotalHarga;
        }

        // Simpan Booking
        Booking::create([
            'user_id'         => Auth::id(),
            'parking_slot_id' => $request->parking_slot_id,
            'waktu_mulai'     => $request->waktu_mulai,
            'waktu_selesai'   => $request->waktu_selesai,
            'total_harga'     => $totalHarga,
            'status'          => 'pending',
        ]);

        return redirect()->back()->with('success', 'Booking berhasil diajukan! Total estimasi biaya: Rp ' . number_format($totalHarga, 0, ',', '.'));
    }

    /**
     * Konfirmasi Pembayaran Simpel
     */
    public function storePayment(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        if ($booking->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Akses tidak sah!');
        }

        // Ambil nominal langsung dari total_harga booking
        Payment::create([
            'booking_id'        => $booking->id,
            'jumlah_bayar'      => $booking->total_harga ?? 20000,
            'metode_pembayaran' => 'cash/instant',
            'bukti_pembayaran'  => null,
            'status'            => 'pending',
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Konfirmasi pembayaran berhasil dikirim! Menunggu verifikasi dari Admin.');
    }

    /**
     * Riwayat Pembayaran User
     */
    public function paymentHistory()
    {
        $payments = Payment::whereHas('booking', function ($q) {
            $q->where('user_id', Auth::id());
        })->with('booking.parkingSlot')->latest()->get();

        return view('user.payments_history', compact('payments'));
    }

    public function printReceipt($id)
    {
        // Menggunakan Auth::id() agar tidak disangka undefined oleh editor
        $booking = Booking::with(['user', 'parkingSlot'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('user.receipt', compact('booking'));
    }
}
