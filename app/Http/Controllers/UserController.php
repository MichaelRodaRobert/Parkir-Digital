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
        // Tampilkan SEMUA slot parkir di dropdown form agar bisa dipesan untuk hari/waktu lain
        $availableSlots = ParkingSlot::all();

        $myBookings = Booking::with('parkingSlot')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $activeBookingToPay = Booking::where('user_id', Auth::id())
            ->where('status', 'disetujui')
            ->whereDoesntHave('payment')
            ->first();

        return view('user.dashboard', compact('availableSlots', 'myBookings', 'activeBookingToPay'));
    }

    /**
     * Menyimpan Booking Baru dengan Perhitungan Tarif Otomatis
     */
    public function storeBooking(Request $request)
{
    $request->validate([
        'parking_slot_id' => 'required|exists:parking_slots,id',
        'waktu_mulai'      => 'required|date|after_or_equal:now',
        'waktu_selesai'    => 'required|date|after:waktu_mulai',
    ]);

    $slotId = $request->parking_slot_id;
    $waktuMulai = $request->waktu_mulai;
    $waktuSelesai = $request->waktu_selesai;

    // 🔍 PENGECEKAN BENTROK WAKTU (OVERLAP CHECK)
    // Cek apakah slot ini sudah dibooking oleh orang lain pada rentang waktu yang sama
    $isBentrok = Booking::where('parking_slot_id', $slotId)
        ->whereIn('status', ['pending', 'disetujui'])
        ->where(function ($query) use ($waktuMulai, $waktuSelesai) {
            $query->whereBetween('waktu_mulai', [$waktuMulai, $waktuSelesai])
                  ->orWhereBetween('waktu_selesai', [$waktuMulai, $waktuSelesai])
                  ->orWhere(function ($q) use ($waktuMulai, $waktuSelesai) {
                      $q->where('waktu_mulai', '<=', $waktuMulai)
                        ->where('waktu_selesai', '>=', $waktuSelesai);
                  });
        })
        ->exists();

    if ($isBentrok) {
        return redirect()->back()->with('error', '❌ Slot parkir ini sudah dipesan oleh pengguna lain pada rentang jam/tanggal tersebut! Silakan pilih jam atau slot lain.');
    }

    // Hitung estimasi total harga (misal Rp 5.000 / jam)
    $mulai = new \DateTime($waktuMulai);
    $selesai = new \DateTime($waktuSelesai);
    $durasiJam = max(1, ceil(($selesai->getTimestamp() - $mulai->getTimestamp()) / 3600));
    $totalHarga = $durasiJam * 5000;

    Booking::create([
        'user_id'         => Auth::id(),
        'parking_slot_id' => $slotId,
        'waktu_mulai'     => $waktuMulai,
        'waktu_selesai'   => $waktuSelesai,
        'total_harga'     => $totalHarga,
        'status'          => 'pending',
    ]);

    return redirect()->back()->with('success', '✅ Booking berhasil diajukan! Menunggu verifikasi dari Admin.');
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
        $booking = Booking::with(['parkingSlot', 'user', 'payment'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('user.receipt', compact('booking'));
    }
}
