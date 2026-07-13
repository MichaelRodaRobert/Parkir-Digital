<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Pendaftaran Akun') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Alert System -->
            @if(session('alert-success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('alert-success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-3">Nama</th>
                            <th class="p-3">Email</th>
                            <th class="p-3">Status Saat Ini</th>
                            <th class="p-3">Aksi Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">{{ $user->name }}</td>
                                <td class="p-3">{{ $user->email }}</td>
                                <td class="p-3">
                                    <span class="px-2 py-1 text-xs rounded font-bold
                                        {{ $user->status_pendaftaran == 'diterima' ? 'bg-green-200 text-green-800' : '' }}
                                        {{ $user->status_pendaftaran == 'ditolak' ? 'bg-red-200 text-red-800' : '' }}
                                        {{ $user->status_pendaftaran == 'pending' ? 'bg-yellow-200 text-yellow-800' : '' }}">
                                        {{ ucfirst($user->status_pendaftaran) }}
                                    </span>
                                </td>
                                <td class="p-3 flex gap-2">
                                    <!-- Form Menerima Akun -->
                                    <form action="{{ route('admin.users.updateStatus', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="diterima">
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">Terima</button>
                                    </form>

                                    <!-- Form Menolak Akun -->
                                    <form action="{{ route('admin.users.updateStatus', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="ditolak">
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Tolak</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-3 text-center text-gray-500">Belum ada pengguna terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
