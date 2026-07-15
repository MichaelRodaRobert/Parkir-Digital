<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->get();
        return view('admin.announcements', compact('announcements'));
    }

    public function store(Request $request)
    {
        // Validasi disederhanakan, input media dihapus
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required',
        ]);

        // Langsung menyimpan judul dan isi saja
        Announcement::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
        ]);

        return back()->with('alert-success', 'Pengumuman berhasil dibuat.');
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);

        // Proses penghapusan file dari storage dihapus karena sudah tidak memakai media
        $announcement->delete();

        return back()->with('alert-success', 'Pengumuman berhasil dihapus.');
    }

    // 📢 METHOD PATCH: Untuk mengubah status Aktif/Nonaktif tombol
    public function toggle($id)
    {
        $announcement = Announcement::findOrFail($id);

        // Jika pengumuman saat ini nonaktif, kita akan mengaktifkannya
        if (!$announcement->is_active) {
            // Matikan semua pengumuman lain terlebih dahulu agar hanya ada 1 pengumuman aktif di user
            Announcement::where('id', '!=', $id)->update(['is_active' => false]);

            $announcement->is_active = true;
            $message = 'Pengumuman berhasil diaktifkan!';
        } else {
            // Jika sudah aktif, maka kita nonaktifkan
            $announcement->is_active = false;
            $message = 'Pengumuman berhasil dinonaktifkan!';
        }

        $announcement->save();

        return back()->with('alert-success', $message);
    }
}
