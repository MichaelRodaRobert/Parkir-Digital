<!-- SCRIPT CDN ALPINE.JS (Menghidupkan aksi tombol X pop-up) -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<x-app-layout>
    <!-- SLOT HEADER - TEKS PUTIH ERGONOMIS -->
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight tracking-wide flex items-center gap-2">
            <span>🚗</span> {{ __('Dashboard Parkir User') }}
        </h2>
    </x-slot>

    <!-- CONTAINER UTAMA DENGAN BACKGROUND DARK KONSISTEN DENGAN ADMIN -->
    <div x-data="{ showAnnouncement: true }" class="py-10 min-h-screen bg-slate-950 text-slate-100 relative">

        <!-- 🔔 MODAL PENGUMUMAN POP-UP USER (DINAMIS DARI ADMIN / DATABASE) -->
        @if(isset($activeAnnouncement) && $activeAnnouncement)
            <div x-show="showAnnouncement"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="fixed inset-0 z-50 flex items-center justify-center p-4"
                 style="background-color: rgba(2, 6, 23, 0.85); backdrop-filter: blur(10px); display: none;">

                <!-- POPUP CARD SOLID (SESUAI BACKGROUND GELAP ADMIN DENGAN GLOW BLUE/INDIGO) -->
                <div class="relative w-full max-w-xl rounded-3xl p-6 md:p-8 shadow-2xl text-center border border-indigo-500/30 overflow-hidden bg-slate-900 text-white">

                    <!-- BACKGROUND GLOW DEKORASI ALA ADMIN -->
                    <div class="absolute -top-20 -left-20 w-48 h-48 bg-indigo-600/20 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-20 -right-20 w-48 h-48 bg-blue-600/20 rounded-full blur-3xl"></div>

                    <!-- ❌ TOMBOL CLOSE POP-UP -->
                    <button @click="showAnnouncement = false"
                            type="button"
                            title="Tutup Pengumuman"
                            class="absolute top-4 right-4 bg-red-500/20 hover:bg-red-600 text-red-400 hover:text-white font-black w-9 h-9 rounded-xl flex items-center justify-center border border-red-500/30 transition-all duration-200 z-30 cursor-pointer shadow-md">
                        ✕
                    </button>

                    <!-- CONTENT PENGUMUMAN PENGGUNA PARKIR -->
                    <div class="relative z-10">

                        <!-- IKON SHIELD GLOW -->
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-500/10 border border-indigo-400/30 rounded-2xl mb-4 text-indigo-400 text-3xl shadow-inner">
                            📢
                        </div>

                        <!-- 🔹 JUDUL PENGUMUMAN (DINAMIS DARI DATABASE) -->
                        <h2 class="text-2xl md:text-3xl font-black tracking-wider text-white uppercase drop-shadow-md">
                            {{ $activeAnnouncement->judul }}
                        </h2>

                        <p class="text-xs md:text-sm text-indigo-300 mt-1 font-semibold tracking-widest uppercase">
                            Sistem Booking & Pelayanan Parkir Digital
                        </p>

                        <!-- ORNAMEN GARIS AKSEN BLUE -->
                        <div class="flex items-center justify-center gap-2 my-5">
                            <div class="h-[1px] w-16 bg-gradient-to-r from-transparent to-indigo-400"></div>
                            <span class="text-indigo-400 text-xs">◆</span>
                            <div class="h-[1px] w-16 bg-gradient-to-l from-transparent to-indigo-400"></div>
                        </div>

                        <!-- TEKS KETERTIBAN USER -->
                        <p class="text-slate-400 text-xs md:text-sm font-medium">
                            PENGUMUMAN TERBARU CONTROL CENTER
                        </p>

                        <!-- 🔹 MEDIA GAMBAR (JIKA ADA) -->
                        @if($activeAnnouncement->media_path)
                            <div class="my-4">
                                <img src="{{ asset('storage/' . $activeAnnouncement->media_path) }}"
                                     class="w-full max-h-60 object-cover rounded-2xl border border-slate-800 shadow-lg"
                                     alt="Media Pengumuman">
                            </div>
                        @endif

                        <!-- 🔹 ISI PENGUMUMAN (DINAMIS DARI DATABASE) -->
                        <div class="text-xs md:text-sm text-slate-300 max-w-md mx-auto font-light leading-relaxed my-4 p-4 bg-slate-950/50 border border-slate-800 rounded-2xl text-left whitespace-pre-line">
                            {{ $activeAnnouncement->isi }}
                        </div>

                        <!-- BADGE BANNER FITUR USER THM ADMIN -->
                        <div class="grid grid-cols-2 gap-3 mt-6 max-w-md mx-auto">
                            <div class="flex items-center justify-center gap-2 p-3 bg-slate-800/80 border border-indigo-500/30 rounded-2xl text-indigo-300 text-xs font-bold shadow-md">
                                <span class="text-base">🎫</span> Tiket Digital Sah
                            </div>
                            <div class="flex items-center justify-center gap-2 p-3 bg-slate-800/80 border border-blue-500/30 rounded-2xl text-blue-300 text-xs font-bold shadow-md">
                                <span class="text-base">💸</span> Bebas Pungli
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endif

        <!-- DASHBOARD BODY CONTAINER (SESUAI DARK BACKGROUND) -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Alert Notifikasi Jika Akun Belum Diverifikasi -->
            @if(Auth::user()->status_pendaftaran !== 'disetujui')
                <div class="bg-amber-950/40 border-l-4 border-amber-500 p-4 rounded-xl shadow-md border border-amber-500/20 backdrop-blur-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 text-lg">⏳</div>
                        <div class="ml-3">
                            <p class="text-sm font-bold text-amber-300">
                                Akun Anda Sedang Menunggu Verifikasi Admin!
                            </p>
                            <p class="text-xs text-amber-200/80 mt-1">
                                Permintaan verifikasi pendaftaran akun Anda telah dikirimkan ke Admin. Seluruh fitur booking & pembayaran dikunci sampai akun Anda disetujui.
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-emerald-950/40 border-l-4 border-emerald-500 p-4 rounded-xl shadow-md border border-emerald-500/20 backdrop-blur-sm">
                    <p class="text-sm font-bold text-emerald-300">
                        ✓ Akun Anda Terverifikasi!
                    </p>
                    <p class="text-xs text-emerald-200/80">
                        Anda dapat melakukan pemesanan slot parkir dan pembayaran.
                    </p>
                </div>
            @endif

            <!-- Notifikasi Session Flash -->
            @if(session('success'))
                <div class="bg-emerald-950/40 border-l-4 border-emerald-500 text-emerald-300 p-4 rounded-xl shadow-sm border border-emerald-500/20">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-950/40 border-l-4 border-red-500 text-red-300 p-4 rounded-xl shadow-sm border border-red-500/20">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form Pemesanan Parkir (Sesuai Dark Background Dashboard Admin) -->
            <div class="bg-slate-900 p-6 rounded-2xl shadow-xl border border-slate-800">
                <div class="flex items-center justify-between mb-4 border-b border-slate-800 pb-3">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <span>🚗</span> Form Booking Slot Parkir
                    </h3>

                    <!-- Status Pendaftaran Badge -->
                    @if(Auth::user()->status_pendaftaran !== 'disetujui')
                        <span class="text-xs font-semibold px-3 py-1 bg-amber-500/10 text-amber-400 border border-amber-500/30 rounded-full">
                            ⚠️ Akun Menunggu ACC Admin
                        </span>
                    @endif
                </div>

                <!-- Alert jika akun belum disetujui admin -->
                @if(Auth::user()->status_pendaftaran !== 'disetujui')
                    <div class="mb-4 p-3 bg-amber-500/10 border-l-4 border-amber-500 text-amber-300 rounded-r-lg text-xs font-medium">
                        Form pemesanan terkunci karena akun Anda belum diverifikasi/disetujui oleh Admin.
                    </div>
                @endif

                <form action="{{ route('user.booking.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
                        <!-- PILIH SLOT -->
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">
                                Pilih Slot Parkir
                            </label>
                            <select name="parking_slot_id"
                                    class="w-full bg-slate-950 border-slate-700 text-white rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm disabled:bg-slate-800 disabled:text-slate-500 disabled:cursor-not-allowed"
                                    {{ Auth::user()->status_pendaftaran !== 'disetujui' ? 'disabled' : '' }} required>
                                <option value="" class="bg-slate-900 text-white">-- Pilih Slot Available --</option>
                                @foreach($availableSlots ?? [] as $slot)
                                    <option value="{{ $slot->id }}" class="bg-slate-900 text-white">
                                        Slot {{ $slot->nomor_slot ?? $slot->nama_slot }} (Lantai {{ $slot->lantai ?? '1' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- WAKTU MULAI -->
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">
                                Waktu Mulai
                            </label>
                            <input type="datetime-local"
                                   id="waktu_mulai"
                                   name="waktu_mulai"
                                   class="w-full bg-slate-950 border-slate-700 text-white rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm disabled:bg-slate-800 disabled:text-slate-500 disabled:cursor-not-allowed"
                                   {{ Auth::user()->status_pendaftaran !== 'disetujui' ? 'disabled' : '' }} required>
                        </div>

                        <!-- WAKTU SELESAI -->
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">
                                Waktu Selesai
                            </label>
                            <input type="datetime-local"
                                   id="waktu_selesai"
                                   name="waktu_selesai"
                                   class="w-full bg-slate-950 border-slate-700 text-white rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm disabled:bg-slate-800 disabled:text-slate-500 disabled:cursor-not-allowed"
                                   {{ Auth::user()->status_pendaftaran !== 'disetujui' ? 'disabled' : '' }} required>
                        </div>
                    </div>

                    <!-- TOMBOL SUBMIT -->
                    <div class="flex justify-end">
                        <button type="submit"
                                class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm rounded-xl shadow-lg shadow-indigo-600/30 transition-all active:scale-95 disabled:bg-slate-800 disabled:text-slate-600 disabled:shadow-none disabled:cursor-not-allowed flex items-center gap-2"
                                {{ Auth::user()->status_pendaftaran !== 'disetujui' ? 'disabled' : '' }}>
                            <span>Pesan Slot Parkir</span>
                            <span class="text-base">➔</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Auto Validasi Jam Selesai -->
            <script>
                document.getElementById('waktu_mulai')?.addEventListener('change', function() {
                    const waktuMulai = this.value;
                    const waktuSelesaiInput = document.getElementById('waktu_selesai');
                    if (waktuMulai) {
                        waktuSelesaiInput.min = waktuMulai;
                    }
                });
            </script>

            <!-- CARD KONFIRMASI PEMBAYARAN SIMPEL -->
            @if(isset($activeBookingToPay) && $activeBookingToPay)
                <div class="bg-slate-900 border-2 border-amber-500/50 p-6 rounded-2xl shadow-xl">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-amber-400 flex items-center gap-2">
                            <span>🎉</span> Booking Anda Telah Disetujui! Silakan Lakukan Pembayaran
                        </h3>
                        <span class="px-3 py-1 bg-amber-500/20 text-amber-300 text-xs font-bold rounded-full border border-amber-500/30">
                            Menunggu Pembayaran
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-slate-300 mb-6 bg-slate-950 p-4 rounded-xl border border-slate-800">
                        <div>
                            <p><strong class="text-white">Slot Parkir:</strong> Slot {{ $activeBookingToPay->parkingSlot->nomor_slot ?? $activeBookingToPay->parkingSlot->nama_slot ?? '-' }}</p>
                            <p><strong class="text-white">Waktu Mulai:</strong> {{ $activeBookingToPay->waktu_mulai }}</p>
                        </div>
                        <div>
                            <p><strong class="text-white">Waktu Selesai:</strong> {{ $activeBookingToPay->waktu_selesai }}</p>
                            <p><strong class="text-white">Total Tagihan:</strong> <span class="text-emerald-400 font-bold text-base">Rp {{ number_format($activeBookingToPay->total_harga ?? 20000, 0, ',', '.') }}</span></p>
                        </div>
                    </div>

                    <!-- Form Konfirmasi Bayar -->
                    <form action="{{ route('user.payment.store', $activeBookingToPay->id) }}" method="POST" class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-950 p-4 rounded-xl border border-slate-800">
                        @csrf
                        <div>
                            <p class="text-xs text-slate-400 font-semibold uppercase">Metode Pembayaran</p>
                            <p class="text-sm font-bold text-white">Bayar di Tempat (Tunai / Cash) / Instant</p>
                        </div>

                        <button type="submit"
                                onclick="return confirm('Apakah Anda yakin ingin mengonfirmasi pembayaran ini?')"
                                class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm rounded-xl shadow-lg shadow-emerald-600/30 transition flex items-center gap-2">
                            <span>✅</span> Konfirmasi Pembayaran
                        </button>
                    </form>
                </div>
            @endif

            <!-- 🎟️ TIKET & STRUK PARKIR (MEMUAT PENDING & DISETUJUI) -->
            @if(isset($myBookings) && $myBookings->count() > 0)
                <div class="bg-slate-900 p-6 rounded-2xl shadow-xl border border-slate-800">
                    <h3 class="text-lg font-bold text-white mb-4">🎟️ Tiket & Struk Parkir Anda</h3>

                    <div class="space-y-3">
                        @foreach($myBookings as $b)
                            <div class="p-4 rounded-xl border border-slate-800 bg-slate-950 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <!-- DYNAMIC KETERANGAN STATUS -->
                                        @if($b->status === 'disetujui')
                                            <span class="px-2.5 py-0.5 text-xs font-bold rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                                                ✓ Booking Disetujui
                                            </span>
                                        @elseif($b->status === 'pending')
                                            <span class="px-2.5 py-0.5 text-xs font-bold rounded-full bg-amber-500/20 text-amber-400 border border-amber-500/30">
                                                ⏳ Pending (Menunggu ACC Admin)
                                            </span>
                                        @else
                                            <span class="px-2.5 py-0.5 text-xs font-bold rounded-full bg-red-500/20 text-red-400 border border-red-500/30">
                                                ✕ Ditolak
                                            </span>
                                        @endif

                                        <span class="text-xs text-slate-400 font-mono">Kode Tiket: #PRK-{{ str_pad($b->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                    <p class="text-sm font-bold text-white">
                                        Slot {{ $b->parkingSlot->nomor_slot ?? $b->parkingSlot->nama_slot ?? '-' }}
                                    </p>
                                    <p class="text-xs text-slate-400">
                                        🕒 {{ $b->waktu_mulai }} s/d {{ $b->waktu_selesai }}
                                    </p>
                                    <p class="text-xs font-bold text-emerald-400 mt-0.5">
                                        Total Biaya: Rp {{ number_format($b->total_harga ?? 20000, 0, ',', '.') }}
                                    </p>
                                </div>

                                <!-- Tombol Cetak Struk -->
                                <div>
                                    <a href="{{ route('user.booking.receipt', $b->id) }}"
                                       target="_blank"
                                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs rounded-xl shadow transition">
                                        <span>🖨️</span> Lihat Struk
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
                   class="inline-flex items-center px-5 py-2.5 bg-slate-800 text-slate-200 border border-slate-700 rounded-xl text-xs font-semibold uppercase tracking-widest hover:bg-slate-700 hover:text-white transition {{ Auth::user()->status_pendaftaran !== 'disetujui' ? 'pointer-events-none opacity-50' : '' }}">
                    📜 Lihat Riwayat Pembayaran
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
