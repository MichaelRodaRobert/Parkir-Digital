<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Riwayat Pembayaran Lunas') }}
            </h2>
            <a href="{{ route('user.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-md text-sm shadow transition">
                ← Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">💳 Transaksi Parkir yang Telah Dikonfirmasi Lunas</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID Transaksi</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slot Parkir</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu Parkir</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Bayar</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($paidPayments as $pay)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-500">#PAY-{{ $pay->id }}</td>
                                    <td class="px-4 py-3 font-bold text-gray-700">
                                        Slot {{ $pay->booking->parkingSlot->nomor_slot ?? '-' }}
                                        <span class="text-xs font-normal text-gray-500">(Lantai {{ $pay->booking->parkingSlot->lantai ?? '-' }})</span>
                                    </td>
                                    <td class="px-4 py-3 text-xs text-gray-600">
                                        {{ $pay->booking->waktu_mulai }} s/d {{ $pay->booking->waktu_selesai }}
                                    </td>
                                    <td class="px-4 py-3 text-sm font-semibold text-green-700">
                                        Rp {{ number_format($pay->jumlah_bayar, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">
                                            ✓ LUNAS / VALID
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-gray-500 text-sm">
                                        Belum ada riwayat pembayaran yang dikonfirmasi lunas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
