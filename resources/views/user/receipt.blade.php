<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran Parkir - #PRK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #f3f4f6;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .receipt-card {
            background: #ffffff;
            padding: 24px;
            width: 320px;
            border: 1px dashed #333333;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }
        .text-center { text-align: center; }
        .divider { border-top: 1px dashed #4b5563; margin: 12px 0; }
        .row { display: flex; justify-content: space-between; font-size: 13px; margin: 6px 0; color: #111827; }
        .bold { font-weight: bold; }
        .btn-group {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
            text-align: center;
            text-decoration: none;
            box-sizing: border-box;
        }
        .btn-print {
            background: #111827;
            color: #ffffff;
        }
        .btn-print:hover {
            background: #374151;
        }
        .btn-back {
            background: #e5e7eb;
            color: #374151;
        }
        .btn-back:hover {
            background: #d1d5db;
        }
        @media print {
            body { background: #ffffff; padding: 0; }
            .receipt-card { border: none; box-shadow: none; width: 100%; }
            .btn-group { display: none; }
        }
    </style>
</head>
<body>

    <div class="receipt-card">
        <div class="text-center">
            <h2 style="margin: 0; font-size: 20px; letter-spacing: 1px;">PARKIR DIGITAL</h2>
            <p style="font-size: 11px; margin: 4px 0 0 0; color: #4b5563;">STRUK BUKTI PEMBAYARAN</p>
        </div>

        <div class="divider"></div>

        <div class="row">
            <span>No. Tiket:</span>
            <span class="bold">#PRK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="row">
            <span>Nama User:</span>
            <span>{{ $booking->user->name ?? 'User' }}</span>
        </div>
        <div class="row">
            <span>Slot Parkir:</span>
            <span class="bold">Slot {{ $booking->parkingSlot->nomor_slot ?? $booking->parkingSlot->nama_slot ?? '-' }}</span>
        </div>

        <div class="divider"></div>

        <div class="row">
            <span>Waktu Masuk:</span>
            <span>{{ date('d/m/Y H:i', strtotime($booking->waktu_mulai)) }}</span>
        </div>
        <div class="row">
            <span>Waktu Keluar:</span>
            <span>{{ date('d/m/Y H:i', strtotime($booking->waktu_selesai)) }}</span>
        </div>

        <div class="divider"></div>

        <!-- STATUS DINAMIS DI STRUK -->
        <div class="row">
            <span>Status Booking:</span>
            @if($booking->status === 'disetujui')
                <span class="bold" style="color: #16a34a;">BOOKING DISETUJUI</span>
            @elseif($booking->status === 'pending')
                <span class="bold" style="color: #d97706;">PENDING (MENUNGGU ACC)</span>
            @else
                <span class="bold" style="color: #dc2626;">DITOLAK</span>
            @endif
        </div>

        <div class="row" style="font-size: 15px; margin-top: 8px;">
            <span class="bold">TOTAL:</span>
            <span class="bold">Rp {{ number_format($booking->total_harga ?? 20000, 0, ',', '.') }}</span>
        </div>

        <div class="divider"></div>

        <div class="text-center" style="font-size: 11px; margin-top: 12px; color: #4b5563;">
            <p style="margin: 2px 0;">Terima Kasih Atas Kunjungan Anda!</p>
            <p style="margin: 2px 0;">Simpan struk ini sebagai bukti resmi.</p>
        </div>

        <!-- Group Tombol Aksi -->
        <div class="btn-group">
            <button onclick="window.print()" class="btn btn-print">🖨️ Cetak / Simpan PDF</button>
            <a href="{{ route('user.dashboard') }}" class="btn btn-back">⬅ Kembali ke Dashboard</a>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
