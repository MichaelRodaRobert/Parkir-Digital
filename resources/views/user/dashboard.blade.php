<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Parkir User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Alert Notifikasi Jika Akun Belum Diverifikasi -->
            @if(Auth::user()->status_pendaftaran !== 'disetujui')
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            ⏳
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-bold text-yellow-800">
                                Akun Anda Sedang Menunggu Verifikasi Admin!
                            </p>
                            <p class="text-xs text-yellow-700 mt-1">
                                Permintaan verifikasi pendaftaran akun Anda telah dikirimkan ke Admin. Seluruh fitur booking & pembayaran dikunci sampai akun Anda disetujui.
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm">
                    <p class="text-sm font-bold text-green-800">
                        ✓ Akun Anda Terverifikasi!
                    </p>
                    <p class="text-xs text-green-700">
                        Anda dapat melakukan pemesanan slot parkir dan pembayaran.
                    </p>
                </div>
            @endif

            <!-- Notifikasi Session Flash -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form Pemesanan Parkir -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">🚗 Form Booking Slot Parkir</h3>

                <form action="{{ route('user.booking.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Slot Parkir</label>
                            <select name="parking_slot_id"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-100 disabled:cursor-not-allowed"
                                    {{ Auth::user()->status_pendaftaran !== 'disetujui' ? 'disabled' : '' }} required>
                                <option value="">-- Pilih Slot Available --</option>
                                @foreach($availableSlots ?? [] as $slot)
                                    <option value="{{ $slot->id }}">Slot {{ $slot->nomor_slot ?? $slot->nama_slot }} (Lantai {{ $slot->lantai ?? '1' }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Mulai</label>
                            <input type="datetime-local" name="waktu_mulai"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-100 disabled:cursor-not-allowed"
                                   {{ Auth::user()->status_pendaftaran !== 'disetujui' ? 'disabled' : '' }} required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Selesai</label>
                            <input type="datetime-local" name="waktu_selesai"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-100 disabled:cursor-not-allowed"
                                   {{ Auth::user()->status_pendaftaran !== 'disetujui' ? 'disabled' : '' }} required>
                        </div>
                    </div>

                    <button type="submit"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-md shadow transition disabled:bg-gray-400 disabled:cursor-not-allowed"
                            {{ Auth::user()->status_pendaftaran !== 'disetujui' ? 'disabled' : '' }}>
                        Pesan Slot Parkir
                    </button>
                </form>
            </div>

            <!-- CARD KONFIRMASI PEMBAYARAN SIMPEL -->
            @if(isset($activeBookingToPay) && $activeBookingToPay)
                <div class="bg-yellow-50 border-2 border-yellow-400 p-6 rounded-lg shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-yellow-900 flex items-center gap-2">
                            <span>🎉</span> Booking Anda Telah Disetujui! Silakan Lakukan Pembayaran
                        </h3>
                        <span class="px-3 py-1 bg-yellow-200 text-yellow-800 text-xs font-bold rounded-full">
                            Menunggu Pembayaran
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700 mb-6 bg-white p-4 rounded-md border border-yellow-200">
                        <div>
                            <p><strong class="text-gray-900">Slot Parkir:</strong> Slot {{ $activeBookingToPay->parkingSlot->nomor_slot ?? $activeBookingToPay->parkingSlot->nama_slot ?? '-' }}</p>
                            <p><strong class="text-gray-900">Waktu Mulai:</strong> {{ $activeBookingToPay->waktu_mulai }}</p>
                        </div>
                        <div>
                            <p><strong class="text-gray-900">Waktu Selesai:</strong> {{ $activeBookingToPay->waktu_selesai }}</p>
                            <p><strong class="text-gray-900">Total Tagihan:</strong> <span class="text-green-600 font-bold text-base">Rp {{ number_format($activeBookingToPay->total_harga ?? 20000, 0, ',', '.') }}</span></p>
                        </div>
                    </div>

                    <!-- Form Konfirmasi Bayar -->
                    <form action="{{ route('user.payment.store', $activeBookingToPay->id) }}" method="POST" class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-4 rounded-md border border-gray-200">
                        @csrf
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase">Metode Pembayaran</p>
                            <p class="text-sm font-bold text-gray-800">Bayar di Tempat (Tunai / Cash) / Instant</p>
                        </div>

                        <button type="submit"
                                onclick="return confirm('Apakah Anda yakin ingin mengonfirmasi pembayaran ini?')"
                                class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-bold text-sm rounded-md shadow transition flex items-center gap-2">
                            <span>✅</span> Konfirmasi Pembayaran
                        </button>
                    </form>
                </div>
            @endif

            <!-- TIKET & STRUK PARKIR SIAP DICETAK -->
            @php
                $approvedBookings = isset($myBookings) ? $myBookings->where('status', 'disetujui') : collect();
            @endphp

            @if($approvedBookings->count() > 0)
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">🎟️ Tiket & Struk Parkir Anda</h3>

                    <div class="space-y-3">
                        @foreach($approvedBookings as $b)
                            <div class="p-4 rounded-lg border border-gray-200 bg-gray-50 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="px-2.5 py-0.5 text-xs font-bold rounded-full bg-green-100 text-green-800">
                                            ✓ Booking Disetujui
                                        </span>
                                        <span class="text-xs text-gray-500 font-mono">Kode Tiket: #PRK-{{ str_pad($b->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                    <p class="text-sm font-bold text-gray-800">
                                        Slot {{ $b->parkingSlot->nomor_slot ?? $b->parkingSlot->nama_slot ?? '-' }}
                                    </p>
                                    <p class="text-xs text-gray-600">
                                        🕒 {{ $b->waktu_mulai }} s/d {{ $b->waktu_selesai }}
                                    </p>
                                    <p class="text-xs font-bold text-green-700 mt-0.5">
                                        Total Biaya: Rp {{ number_format($b->total_harga ?? 20000, 0, ',', '.') }}
                                    </p>
                                </div>

                                <!-- Tombol Cetak Struk (Membuka Tab Baru Aman tanpa 404 saat back) -->
                                <div>
                                    <a href="{{ route('user.booking.receipt', $b->id) }}"
                                       target="_blank"
                                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-md shadow transition">
                                        <span>🖨️</span> Cetak Struk
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Link Riwayat Pembayaran -->
            <div class="flex justify-end">
                <a href="{{ route('user.payments.history') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md text-xs font-semibold uppercase tracking-widest hover:bg-gray-700 transition {{ Auth::user()->status_pendaftaran !== 'disetujui' ? 'pointer-events-none opacity-50' : '' }}">
                    📜 Lihat Riwayat Pembayaran
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
