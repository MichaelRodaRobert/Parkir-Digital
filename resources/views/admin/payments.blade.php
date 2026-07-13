<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('alert-success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('alert-success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-3">Nama Pemesan</th>
                            <th class="p-3">Total Bayar</th>
                            <th class="p-3">Bukti Pembayaran (Multimedia)</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">{{ $payment->booking->user->name ?? 'N/A' }}</td>
                                <td class="p-3">Rp {{ number_format($payment->total_bayar, 0, ',', '.') }}</td>
                                <td class="p-3">
                                    <!-- Menampilkan Gambar Bukti Transfer -->
                                    @if($payment->bukti_pembayaran)
                                        <a href="{{ asset('storage/' . $payment->bukti_pembayaran) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $payment->bukti_pembayaran) }}" alt="Bukti Transfer" class="h-16 w-16 object-cover rounded border">
                                        </a>
                                    @else
                                        <span class="text-gray-400">Tidak ada gambar</span>
                                    @endif
                                </td>
                                <td class="p-3">
                                    <span class="px-2 py-1 text-xs rounded font-bold
                                        {{ $payment->status_pembayaran == 'diterima' ? 'bg-green-200 text-green-800' : '' }}
                                        {{ $payment->status_pembayaran == 'ditolak' ? 'bg-red-200 text-red-800' : '' }}
                                        {{ $payment->status_pembayaran == 'pending' ? 'bg-yellow-200 text-yellow-800' : '' }}">
                                        {{ ucfirst($payment->status_pembayaran) }}
                                    </span>
                                </td>
                                <td class="p-3 flex gap-2">
                                    <form action="{{ route('admin.payments.updateStatus', $payment->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="diterima">
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">Terima</button>
                                    </form>

                                    <form action="{{ route('admin.payments.updateStatus', $payment->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="ditolak">
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Tolak</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-3 text-center text-gray-500">Belum ada transaksi pembayaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
