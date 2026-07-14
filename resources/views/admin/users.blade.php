<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Pendaftaran User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Alert Notifikasi Sukses -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">👥 Daftar Akun User (Verifikasi Pendaftaran)</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Verifikasi</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi Admin</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                            {{ $user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($user->status_pendaftaran === 'disetujui')
                                                <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">
                                                    ✓ Disetujui
                                                </span>
                                            @elseif($user->status_pendaftaran === 'ditolak')
                                                <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">
                                                    ✕ Ditolak
                                                </span>
                                            @else
                                                <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800 animate-pulse">
                                                    ⏳ Menunggu Verifikasi Admin
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if($user->status_pendaftaran === 'disetujui')
                                                <!-- Jika Sudah Diterima -->
                                                <span class="px-3 py-1.5 inline-block text-xs font-bold text-green-700 bg-green-100 border border-green-300 rounded-md select-none">
                                                    Sudah Diterima
                                                </span>
                                            @elseif($user->status_pendaftaran === 'ditolak')
                                                <!-- Jika Sudah Ditolak -->
                                                <span class="px-3 py-1.5 inline-block text-xs font-bold text-red-700 bg-red-100 border border-red-300 rounded-md select-none">
                                                    Sudah Ditolak
                                                </span>
                                            @else
                                                <!-- Jika Masih Pending (Tampilkan Tombol) -->
                                                <div class="flex justify-center space-x-2">
                                                    <form action="{{ route('admin.users.approve', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                                onclick="return confirm('Terima pendaftaran user {{ $user->name }}?')"
                                                                class="px-3 py-1.5 font-bold text-xs bg-green-600 hover:bg-green-700 text-black rounded-md shadow transition">
                                                            ✓ Terima
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('admin.users.reject', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                                onclick="return confirm('Tolak pendaftaran user {{ $user->name }}?')"
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
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Belum ada data pendaftaran user.
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
