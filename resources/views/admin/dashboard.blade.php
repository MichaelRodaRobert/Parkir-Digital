<x-app-layout>

    <div class="py-10 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- NOTIFIKASI FLASH -->
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-xl shadow-sm text-sm font-medium flex items-center justify-between">
                    <span class="flex items-center gap-2">✨ {{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 p-4 rounded-xl shadow-sm text-sm font-medium flex items-center justify-between">
                    <span class="flex items-center gap-2">⚠️ {{ session('error') }}</span>
                </div>
            @endif

            <!-- 📊 GRID STATISTIK FUTURISTIK -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">

                <!-- CARD 1: USER PENDING ACC -->
                <div class="group relative bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-amber-500/10 rounded-full blur-xl group-hover:bg-amber-500/20 transition-all"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <p class="text-[11px] font-bold text-amber-600 uppercase tracking-wider">User Pending ACC</p>
                        <div class="p-2.5 bg-amber-50 text-amber-600 rounded-xl font-bold text-sm shadow-inner">
                            ⏳
                        </div>
                    </div>
                    <div class="mt-4 relative z-10">
                        <h3 class="text-3xl font-black text-slate-800 tracking-tight">
                            {{ $pendingUsers ?? 0 }}
                        </h3>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between relative z-10">
                        <a href="{{ route('admin.users') }}" class="text-xs font-bold text-amber-600 hover:text-amber-700 inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                            Verifikasi Sekarang <span class="text-sm">→</span>
                        </a>
                    </div>
                </div>

                <!-- CARD 2: TOTAL USER -->
                <div class="group relative bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-indigo-500/10 rounded-full blur-xl group-hover:bg-indigo-500/20 transition-all"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <p class="text-[11px] font-bold text-indigo-600 uppercase tracking-wider">Total User</p>
                        <div class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl font-bold text-sm shadow-inner">
                            👥
                        </div>
                    </div>
                    <div class="mt-4 relative z-10">
                        <h3 class="text-3xl font-black text-slate-800 tracking-tight">
                            {{ $totalUsers ?? 0 }}
                        </h3>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between relative z-10">
                        <a href="{{ route('admin.users') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                            Lihat Semua <span class="text-sm">→</span>
                        </a>
                    </div>
                </div>

                <!-- CARD 3: SISA SLOT TERSEDIA -->
                <div class="group relative bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-emerald-500/10 rounded-full blur-xl group-hover:bg-emerald-500/20 transition-all"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <p class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider">Slot Available</p>
                        <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl font-bold text-sm shadow-inner">
                            🚗
                        </div>
                    </div>
                    <div class="mt-4 relative z-10 flex items-baseline gap-2">
                        <h3 class="text-3xl font-black text-slate-800 tracking-tight">
                            {{ $totalSlot ?? 0 }}
                        </h3>
                        <span class="text-xs font-semibold text-slate-400">/ {{ $totalSemuaSlot ?? 0 }} Total</span>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 relative z-10">
                        <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                            @php
                                $percent = ($totalSemuaSlot ?? 0) > 0 ? (($totalSlot ?? 0) / $totalSemuaSlot) * 100 : 0;
                            @endphp
                            <div class="bg-emerald-500 h-full rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- CARD 4: BOOKING PENDING -->
                <div class="group relative bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-sky-500/10 rounded-full blur-xl group-hover:bg-sky-500/20 transition-all"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <p class="text-[11px] font-bold text-sky-600 uppercase tracking-wider">Booking Pending</p>
                        <div class="p-2.5 bg-sky-50 text-sky-600 rounded-xl font-bold text-sm shadow-inner">
                            📑
                        </div>
                    </div>
                    <div class="mt-4 relative z-10">
                        <h3 class="text-3xl font-black text-slate-800 tracking-tight">
                            {{ $pendingBookings ?? 0 }}
                        </h3>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between relative z-10">
                        <a href="{{ route('admin.bookings') }}" class="text-xs font-bold text-sky-600 hover:text-sky-700 inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                            Kelola Booking <span class="text-sm">→</span>
                        </a>
                    </div>
                </div>

                <!-- CARD 5: TOTAL PEMBAYARAN -->
                <div class="group relative bg-gradient-to-br from-slate-900 to-indigo-950 p-5 rounded-2xl shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden text-white">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-500/30 rounded-full blur-2xl group-hover:bg-indigo-500/50 transition-all"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <p class="text-[11px] font-bold text-indigo-300 uppercase tracking-wider">Total Revenue</p>
                        <div class="p-2.5 bg-white/10 backdrop-blur-md rounded-xl font-bold text-sm border border-white/10">
                            💳
                        </div>
                    </div>
                    <div class="mt-4 relative z-10">
                        <h3 class="text-2xl font-black text-white tracking-tight">
                            Rp {{ number_format($totalPayments ?? 0, 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="mt-4 pt-3 border-t border-white/10 flex items-center justify-between relative z-10">
                        <a href="{{ route('admin.payments') }}" class="text-xs font-bold text-indigo-300 hover:text-white inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                            Rincian Transaksi <span class="text-sm">→</span>
                        </a>
                    </div>
                </div>

            </div>

            <!-- ⚡ QUICK ACTION MENU FUTURISTIK -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 tracking-tight flex items-center gap-2">
                            <span>⚡</span> Control Center Quick Menu
                        </h3>
                        <p class="text-xs text-slate-400 mt-1">Akses cepat manajemen dan pemrosesan data sistem parkir</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                    <!-- MENU 1 -->
                    <a href="{{ route('admin.users') }}" class="group relative p-5 rounded-2xl border border-slate-100 bg-slate-50/50 hover:bg-indigo-600 hover:border-indigo-600 transition-all duration-300 flex items-center justify-between shadow-sm hover:shadow-indigo-500/25 hover:shadow-lg">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 group-hover:bg-white/20 group-hover:text-white flex items-center justify-center text-xl font-bold transition-colors">
                                👥
                            </div>
                            <div>
                                <p class="font-bold text-sm text-slate-800 group-hover:text-white transition-colors">Verifikasi User</p>
                                <p class="text-xs text-slate-500 group-hover:text-indigo-100 transition-colors mt-0.5">Setujui pendaftaran akun</p>
                            </div>
                        </div>
                        <span class="text-slate-400 group-hover:text-white group-hover:translate-x-1 transition-all text-lg">➔</span>
                    </a>

                    <!-- MENU 2 -->
                    <a href="{{ route('admin.bookings') }}" class="group relative p-5 rounded-2xl border border-slate-100 bg-slate-50/50 hover:bg-sky-600 hover:border-sky-600 transition-all duration-300 flex items-center justify-between shadow-sm hover:shadow-sky-500/25 hover:shadow-lg">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-sky-100 text-sky-600 group-hover:bg-white/20 group-hover:text-white flex items-center justify-center text-xl font-bold transition-colors">
                                🚗
                            </div>
                            <div>
                                <p class="font-bold text-sm text-slate-800 group-hover:text-white transition-colors">Booking Parkir</p>
                                <p class="text-xs text-slate-500 group-hover:text-sky-100 transition-colors mt-0.5">Kelola reservasi slot</p>
                            </div>
                        </div>
                        <span class="text-slate-400 group-hover:text-white group-hover:translate-x-1 transition-all text-lg">➔</span>
                    </a>

                    <!-- MENU 3 -->
                    <a href="{{ route('admin.payments') }}" class="group relative p-5 rounded-2xl border border-slate-100 bg-slate-50/50 hover:bg-emerald-600 hover:border-emerald-600 transition-all duration-300 flex items-center justify-between shadow-sm hover:shadow-emerald-500/25 hover:shadow-lg">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 group-hover:bg-white/20 group-hover:text-white flex items-center justify-center text-xl font-bold transition-colors">
                                💳
                            </div>
                            <div>
                                <p class="font-bold text-sm text-slate-800 group-hover:text-white transition-colors">Validasi Pembayaran</p>
                                <p class="text-xs text-slate-500 group-hover:text-emerald-100 transition-colors mt-0.5">Konfirmasi transaksi masuk</p>
                            </div>
                        </div>
                        <span class="text-slate-400 group-hover:text-white group-hover:translate-x-1 transition-all text-lg">➔</span>
                    </a>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
