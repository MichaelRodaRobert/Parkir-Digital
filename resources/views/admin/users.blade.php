<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Pengguna Parkir') }}
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
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Daftar Pengguna Registrasi</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Akun</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($users as $user)
                                    <tr>
                                        <!-- Nama Pengguna -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            {{ $user->name }}
                                        </td>

                                        <!-- Email Pengguna -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $user->email }}
                                        </td>

                                        <!-- Status Pendaftaran -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($user->status_pendaftaran == 'diterima' || $user->status_pendaftaran == 'aktif')
                                                <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800">
                                                    Aktif / Diterima
                                                </span>
                                            @elseif($user->status_pendaftaran == 'ditolak')
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
                                            @if($user->status_pendaftaran == 'pending')
                                                {{-- Tombol Tampil Jika Status Masih Pending --}}
                                                <div class="flex justify-center space-x-2">
                                                    <!-- Tombol Setujui -->
                                                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status_pendaftaran" value="diterima">
                                                        <button type="submit"
                                                                onclick="return confirm('Setujui akun ini?')"
                                                                style="background-color: #16a34a; color: white;"
                                                                class="px-3 py-1.5 font-bold text-xs rounded-md shadow transition hover:opacity-90">
                                                            ✓ Setujui
                                                        </button>
                                                    </form>

                                                    <!-- Tombol Tolak -->
                                                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status_pendaftaran" value="ditolak">
                                                        <button type="submit"
                                                                onclick="return confirm('Tolak akun ini?')"
                                                                style="background-color: #dc2626; color: white;"
                                                                class="px-3 py-1.5 font-bold text-xs rounded-md shadow transition hover:opacity-90">
                                                            ✕ Tolak
                                                        </button>
                                                    </form>
                                                </div>
                                            @elseif($user->status_pendaftaran == 'diterima' || $user->status_pendaftaran == 'aktif')
                                                {{-- Jika Sudah Diterima --}}
                                                <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-bold bg-green-100 text-green-800 border border-green-300">
                                                    ✓ Sudah Disetujui
                                                </span>
                                            @else
                                                {{-- Jika Ditolak --}}
                                                <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-bold bg-red-100 text-red-800 border border-red-300">
                                                    ✕ Akun Ditolak
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Belum ada pengguna yang mendaftar.
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
