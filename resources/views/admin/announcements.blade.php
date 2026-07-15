<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white-800 leading-tight">
            {{ __('Kelola Pengumuman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Alert Sukses -->
            @if (session('success'))
                <div class="mb-4 text-sm font-medium text-green-600 bg-green-100 p-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- KARTU 1: FORM BUAT PENGUMUMAN -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Buat Pengumuman Baru</h3>

                <form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-gray-900">Judul</label>
                        <input type="text" name="judul" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-gray-900 bg-white">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900">Isi Pengumuman</label>
                        <textarea name="isi" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-gray-900 bg-white"></textarea>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <label for="is_active" class="ml-2 block text-sm font-semibold text-gray-900">Aktifkan Langsung Pop-Up Ini</label>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-semibold shadow">
                            Simpan Pengumuman
                        </button>
                    </div>
                </form>
            </div>

            <!-- KARTU 2: DAFTAR PENGUMUMAN -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Daftar Pengumuman</h3>

                <div class="space-y-4">
                    @forelse($announcements as $announcement)
                        <div class="flex justify-between items-start border-b border-gray-200 pb-4 last:border-0 last:pb-0">
                            <div class="space-y-1">
                                <!-- Judul Pengumuman (Hitam & Tebal) -->
                                <h4 class="text-md font-bold text-gray-900 flex items-center gap-2">
                                    {{ $announcement->judul }}

                                    <!-- Indikator Status Aktif/Nonaktif -->
                                    <form action="{{ route('admin.announcements.toggle', $announcement->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-xs px-2 py-0.5 font-semibold rounded-full {{ $announcement->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $announcement->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </button>
                                    </form>
                                </h4>
                                <!-- Isi Pengumuman (Abu-abu Gelap agar Kontras) -->
                                <p class="text-sm text-gray-800 whitespace-pre-line">{{ $announcement->isi }}</p>
                            </div>

                            <!-- Tombol Aksi Hapus -->
                            <div>
                                <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-red-600 text-white text-xs font-semibold rounded hover:bg-red-700 transition shadow">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center py-4">Belum ada pengumuman yang dibuat.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
