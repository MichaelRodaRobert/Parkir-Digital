<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <h3 class="text-lg font-bold text-gray-800 mb-6">📊 Ringkasan Sistem Parkir</h3>

            <!-- Grid Kartu Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">

                <!-- 1. User Pending Verifikasi -->
                <div class="bg-white p-5 rounded-lg shadow-sm border border-yellow-300">
                    <div class="text-xs font-bold text-yellow-600 uppercase">User Pending ACC</div>
                    <div class="text-2xl font-black text-gray-800 mt-2">{{ $pendingUsers ?? 0 }}</div>
                    <a href="{{ route('admin.users') }}" class="text-xs text-yellow-600 hover:underline mt-2 inline-block font-semibold">
                        Verifikasi →
                    </a>
                </div>

                <!-- 2. Total Registered Users -->
                <div class="bg-white p-5 rounded-lg shadow-sm border border-blue-200">
                    <div class="text-xs font-bold text-blue-600 uppercase">Total User</div>
                    <div class="text-2xl font-black text-gray-800 mt-2">{{ $totalUsers ?? 0 }}</div>
                    <a href="{{ route('admin.users') }}" class="text-xs text-blue-600 hover:underline mt-2 inline-block font-semibold">
                        Lihat Semua →
                    </a>
                </div>

                <!-- 3. Total Slot Parkir -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <p class="text-xs font-bold text-gray-500 uppercase">SISA SLOT TERSEDIA</p>
                    <h3 class="text-3xl font-extrabold text-indigo-600 mt-2">
                        {{ $totalSlot }}
                    </h3>
                </div>

                <!-- 4. Pending Booking -->
                <div class="bg-white p-5 rounded-lg shadow-sm border border-orange-200">
                    <div class="text-xs font-bold text-orange-600 uppercase">Booking Pending</div>
                    <div class="text-2xl font-black text-gray-800 mt-2">{{ $pendingBookings ?? 0 }}</div>
                    <a href="{{ route('admin.bookings') }}" class="text-xs text-orange-600 hover:underline mt-2 inline-block font-semibold">
                        Kelola Booking →
                    </a>
                </div>

                <!-- 5. Pending Payment -->
                <div class="bg-white p-5 rounded-lg shadow-sm border border-green-200">
                    <div class="text-xs font-bold text-green-600 uppercase">Pembayaran Pending</div>
                    <div class="text-2xl font-black text-gray-800 mt-2">{{ $pendingPayments ?? 0 }}</div>
                    <a href="{{ route('admin.payments') }}" class="text-xs text-green-600 hover:underline mt-2 inline-block font-semibold">
                        Cek Pembayaran →
                    </a>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
