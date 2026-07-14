<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Pembayaran User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Alert Notifikasi Flash -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">💳 Daftar Verifikasi Transaksi Pembayaran</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slot Parkir</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah Bayar</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Metode</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Pembayaran</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi Admin</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($payments as $payment)
                                    <tr>
                                        <!-- Nama User -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                            {{ $payment->booking->user->name ?? 'User Tidak Ditemukan' }}
                                        </td>

                                        <!-- Slot Parkir -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            Slot {{ $payment->booking->parkingSlot->nomor_slot ?? $payment->booking->parkingSlot->nama_slot ?? '-' }}
                                        </td>

                                        <!-- Jumlah Bayar -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-700">
                                            Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}
                                        </td>

                                        <!-- Metode Pembayaran -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 uppercase">
                                            {{ $payment->metode_pembayaran ?? 'Cash / Instant' }}
                                        </td>

                                        <!-- Status Pembayaran Badge -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($payment->status === 'disetujui' || $payment->status === 'lunas' || $payment->status === 'success')
                                                <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">
                                                    ✓ Pembayaran Disetujui
                                                </span>
                                            @elseif($payment->status === 'ditolak')
                                                <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">
                                                    ✕ Pembayaran Ditolak
                                                </span>
                                            @else
                                                <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800 animate-pulse">
                                                    ⏳ Menunggu Verifikasi
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Tombol Aksi / Keterangan -->
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if($payment->status === 'disetujui' || $payment->status === 'lunas' || $payment->status === 'success')
                                                <span class="px-3 py-1.5 inline-block text-xs font-bold text-green-700 bg-green-100 border border-green-300 rounded-md select-none">
                                                    Sudah Diterima
                                                </span>
                                            @elseif($payment->status === 'ditolak')
                                                <span class="px-3 py-1.5 inline-block text-xs font-bold text-red-700 bg-red-100 border border-red-300 rounded-md select-none">
                                                    Sudah Ditolak
                                                </span>
                                            @else
                                                <!-- Jika Status Masih Pending -->
                                                <div class="flex justify-center space-x-2">
                                                    <form action="{{ route('admin.payments.approve', $payment->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                                onclick="return confirm('Setujui pembayaran dari {{ $payment->booking->user->name ?? 'User' }}?')"
                                                                class="px-3 py-1.5 font-bold text-xs bg-green-600 hover:bg-green-700 text-white rounded-md shadow transition">
                                                            ✓ Terima
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                                onclick="return confirm('Tolak pembayaran ini?')"
                                                                class="px-3 py-1.5 font-bold text-xs bg-red-600 hover:bg-red-700 text-white rounded-md shadow transition">
                                                            ✕ Tolak
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Belum ada data verifikasi pembayaran.
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
