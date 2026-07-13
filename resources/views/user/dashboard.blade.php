<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Alert Pesan Sukses -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Alert Pesan Error -->
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Info Status Akun -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-1">Selamat Datang, {{ Auth::user()->name }}!</h3>
                <p class="text-sm text-gray-600">
                    Status Pendaftaran Anda:
                    <span class="px-2 py-0.5 rounded text-xs font-bold bg-green-100 text-green-800">
                        {{ ucfirst(Auth::user()->status_pendaftaran ?? 'aktif') }}
                    </span>
                </p>
            </div>

            <!-- Form Pemesanan Parkir -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">🚗 Form Pemesanan Slot Parkir</h3>

                <form action="{{ route('user.booking.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Slot Parkir</label>
                        <select name="parking_slot_id" required class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">-- Pilih Slot Available --</option>
                            @foreach($slots as $slot)
                                <option value="{{ $slot->id }}">Slot {{ $slot->nomor_slot }} (Lantai {{ $slot->lantai }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Mulai</label>
                        <input type="datetime-local" name="waktu_mulai" required class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Selesai</label>
                        <input type="datetime-local" name="waktu_selesai" required class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                    </div>

                    <div class="md:col-span-3 mt-2">
                        <button type="submit" style="background-color: #059669; color: white;" class="font-bold py-2 px-4 rounded-md text-sm shadow transition hover:opacity-90">
                            Ajukan Booking
                        </button>
                    </div>
                </form>
            </div>

            <!-- 🅿️ CARD TERPISAH: SLOT PARKIR SAYA -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-4 border-b pb-3">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        🅿️ Slot Parkir Saya
                    </h3>
                    <span class="text-xs bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-full font-semibold">
                        Sudah Disetujui
                    </span>
                </div>

                @if($approvedBookings->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($approvedBookings as $approved)
                            <div class="bg-emerald-50/50 p-4 rounded-lg border border-emerald-200 shadow-sm relative overflow-hidden">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <span class="text-xs font-bold text-emerald-700 uppercase bg-emerald-100 px-2 py-0.5 rounded">
                                            Lantai {{ $approved->parkingSlot->lantai ?? '-' }}
                                        </span>
                                        <h4 class="text-2xl font-black text-gray-800 mt-1">
                                            Slot {{ $approved->parkingSlot->nomor_slot ?? '-' }}
                                        </h4>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-400">#BK-{{ $approved->id }}</span>
                                </div>

                                <div class="text-xs text-gray-600 space-y-1.5 bg-white p-3 rounded border border-emerald-100 mt-2">
                                    <div class="flex justify-between">
                                        <span class="text-gray-400">Mulai:</span>
                                        <span class="font-medium text-gray-700">{{ $approved->waktu_mulai }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-400">Selesai:</span>
                                        <span class="font-medium text-gray-700">{{ $approved->waktu_selesai }}</span>
                                    </div>
                                    <div class="flex justify-between pt-1 border-t border-gray-100">
                                        <span class="text-gray-400">Status Bayar:</span>
                                        @if(optional($approved->payment)->status == 'valid')
                                            <span class="font-bold text-green-600">✓ Lunas</span>
                                        @elseif(optional($approved->payment)->status == 'pending')
                                            <span class="font-bold text-yellow-600">Verifikasi Bayar</span>
                                        @else
                                            <span class="font-bold text-red-500">Belum Dibayar</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6 bg-gray-50 rounded-lg border border-dashed border-gray-200">
                        <p class="text-sm text-gray-500 italic">Belum ada booking yang disetujui atau masih menunggu verifikasi admin.</p>
                    </div>
                @endif
            </div>

            <!-- Tabel Pengajuan Booking & Status Pembayaran -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">📋 Daftar Pengajuan & Status Pembayaran</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slot</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu Mulai</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu Selesai</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Booking</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($myBookings as $booking)
                                <tr>
                                    <td class="px-4 py-3 font-bold text-gray-700">Slot {{ $booking->parkingSlot->nomor_slot ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $booking->waktu_mulai }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $booking->waktu_selesai }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 text-xs font-bold rounded-full
                                            {{ $booking->status == 'disetujui' ? 'bg-green-100 text-green-800' : ($booking->status == 'ditolak' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if($booking->status == 'disetujui')
                                            @if($booking->payment)
                                                <span class="px-2 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800">
                                                    Proses Verifikasi Bayar
                                                </span>
                                            @else
                                                <form action="{{ route('user.payment.store', $booking->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" onclick="return confirm('Konfirmasi pembayaran sekarang?')" style="background-color: #2563eb; color: white;" class="font-bold py-1.5 px-4 rounded-md text-xs shadow transition hover:opacity-90">
                                                        💳 Bayar Sekarang
                                                    </button>
                                                </form>
                                            @endif
                                        @elseif($booking->status == 'pending')
                                            <span class="text-xs text-gray-400 italic">Menunggu Persetujuan Admin</span>
                                        @else
                                            <span class="text-xs text-red-400">Booking Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-4 text-center text-gray-500 text-sm">Tidak ada booking aktif yang belum dibayar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
