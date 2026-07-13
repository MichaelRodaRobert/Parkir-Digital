<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Pengumuman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('alert-success'))
                <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('alert-success') }}
                </div>
            @endif

            <!-- Form Tambah Pengumuman -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold mb-4">Buat Pengumuman Baru</h3>
                <form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium">Judul</label>
                        <input type="text" name="judul" class="w-full rounded border-gray-300" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Isi Pengumuman</label>
                        <textarea name="isi" rows="3" class="w-full rounded border-gray-300" required></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Upload Media (Gambar/Video - Opsional)</label>
                        <input type="file" name="media" accept="image/*,video/mp4" class="mt-1">
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Pengumuman</button>
                </form>
            </div>

            <!-- Daftar Pengumuman -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold mb-4">Daftar Pengumuman</h3>
                <div class="space-y-4">
                    @foreach($announcements as $item)
                        <div class="flex justify-between items-center border-b pb-4">
                            <div>
                                <h4 class="font-bold">{{ $item->judul }}</h4>
                                <p class="text-sm text-gray-600">{{ $item->isi }}</p>
                            </div>
                            <form action="{{ route('admin.announcements.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
