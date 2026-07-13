<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pengguna Parkir') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Alert Pesan Sukses / Error --}}
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Status Pendaftaran Account --}}
            @if(Auth::user()->status_pendaftaran === 'pending')
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow-sm">
                    <p class="font-bold">Akun Dalam Verifikasi</p>
                    <p>Status pendaftaran Anda saat ini masih <strong>PENDING</strong>. Silakan tunggu verifikasi dari Admin untuk dapat melakukan booking slot parkir.</p>
                </div>
            @elseif(Auth::user()->status_pendaftaran === 'ditolak')
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                    <p class="font-bold">Pendaftaran Ditolak</p>
                    <p>Mohon maaf, pendaftaran akun Anda ditolak oleh Admin. Silakan hubungi petugas.</p>
                </div>
            @else
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    <p class="font-bold">Akun Terverifikasi</p>
                    <p>Selamat datang, <strong>{{ Auth::user()->name }}</strong>! Akun Anda aktif dan siap melakukan reservasi parkir.</p>
                </div>
            @endif

            {{-- Form Booking Slot Parkir (Muncul jika Akun Diterima) --}}
            @if(Auth::user()->status_pendaftaran === 'diterima')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4 text-gray-900">Formulir Booking Parkir</h3>

                    <form action="{{ route('user.booking.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Slot Parkir Available</label>
                            <select name="parking_slot_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">-- Pilih Slot --</option>
                                @isset($slots)
                                    @foreach($slots as $slot)
                                        <option value="{{ $slot->id }}">
                                            Slot {{ $slot->nomor_slot }} ({{ $slot->lantai }}) - Rp {{ number_format($slot->harga_per_jam) }}/jam
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Mulai</label>
                                <input type="datetime-local" name="waktu_mulai" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Selesai</label>
                                <input type="datetime-local" name="waktu_selesai" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none">
                            Ajukan Booking
                        </button>
                    </form>
                </div>
            @endif

            {{-- Riwayat Booking --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-gray-900">Riwayat Pemesanan Parkir Saya</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Booking</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slot</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if(isset($myBookings) && $myBookings->count() > 0)
                                @foreach($myBookings as $booking)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">#{{ $booking->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Slot {{ $booking->parkingSlot->nomor_slot ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $booking->waktu_mulai }} s/d {{ $booking->waktu_selesai }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $booking->status == 'disetujui' ? 'bg-green-100 text-green-800' : ($booking->status == 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada pemesanan parkir.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
