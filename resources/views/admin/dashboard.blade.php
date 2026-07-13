<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel Kontrol Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Kartu Ringkasan Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
                    <p class="text-sm font-medium text-gray-500">Total Pengguna</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalUsers ?? 0 }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-yellow-500">
                    <p class="text-sm font-medium text-gray-500">User Pending Verifikasi</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $pendingUsers ?? 0 }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-purple-500">
                    <p class="text-sm font-medium text-gray-500">Booking Pending</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $pendingBookings ?? 0 }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500">
                    <p class="text-sm font-medium text-gray-500">Pembayaran Pending</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $pendingPayments ?? 0 }}</p>
                </div>
            </div>

            {{-- Informasi Sambutan --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-2">Selamat Datang di Panel Admin!</h3>
                <p class="text-gray-600">Gunakan menu navigasi untuk mengelola verifikasi akun pengguna, reservasi slot parkir, dan transaksi pembayaran digital.</p>
            </div>

        </div>
    </div>
</x-app-layout>
