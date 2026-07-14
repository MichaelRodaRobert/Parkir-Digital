<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Pemesanan Slot Parkir') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Alert Pesan Sukses -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Daftar Pengajuan Booking Parkir</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slot Parkir</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Booking</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($bookings as $booking)
                                    <tr>
                                        <!-- Pengguna -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            {{ $booking->user->name ?? '-' }}
                                            <div class="text-xs font-normal text-gray-500">{{ $booking->user->email ?? '' }}</div>
                                        </td>

                                        <!-- Slot Parkir -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">
                                            Slot {{ $booking->parkingSlot->nomor_slot ?? '-' }}
                                        </td>

                                        <!-- Waktu Booking -->
                                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                            <div>{{ $booking->waktu_mulai }}</div>
                                            <div class="text-gray-400">s/d {{ $booking->waktu_selesai }}</div>
                                        </td>

                                        <!-- Status -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($booking->status == 'disetujui')
                                                <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800">
                                                    Disetujui
                                                </span>
                                            @elseif($booking->status == 'ditolak')
                                                <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800">
                                                    Ditolak
                                                </span>
                                            @else
                                                <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-800">
                                                    Pending
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Kolom Aksi Verifikasi -->
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if($booking->status == 'pending')
                                                {{-- Tombol Aksi Tampil Hanya Jika Status Masih Pending --}}
                                                <div class="flex justify-center space-x-2">
                                                    <!-- Tombol Setujui -->
<form action="{{ route('admin.bookings.approve', $booking->id) }}" method="POST">
    @csrf
    @method('PATCH') <!-- WAJIB TAMBAHKAN INI karena route-nya PATCH -->
    <button type="submit"
            onclick="return confirm('Setujui pemesanan ini?')"
            style="background-color: #16a34a; color: white;"
            class="px-3 py-1.5 font-bold text-xs rounded-md shadow transition hover:opacity-90">
        ✓ Setujui
    </button>
</form>

<!-- Tombol Tolak -->
<form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST">
    @csrf
    @method('PATCH') <!-- WAJIB TAMBAHKAN INI karena route-nya PATCH -->
    <button type="submit"
            onclick="return confirm('Yakin ingin menolak pemesanan ini?')"
            style="background-color: #dc2626; color: white;"
            class="px-3 py-1.5 font-bold text-xs rounded-md shadow transition hover:opacity-90">
        ✗ Tolak
    </button>
</form>
                                                </div>
                                            @elseif($booking->status == 'disetujui')
                                                {{-- Tampilan Setelah Disetujui --}}
                                                <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-bold bg-green-100 text-green-800 border border-green-300">
                                                    ✓ Sudah Disetujui
                                                </span>
                                            @else
                                                {{-- Tampilan Setelah Ditolak --}}
                                                <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-bold bg-red-100 text-red-800 border border-red-300">
                                                    ✕ Pemesanan Ditolak
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Belum ada data pemesanan slot parkir.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
