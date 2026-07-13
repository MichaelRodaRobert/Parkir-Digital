<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->get();
        return view('admin.announcements', compact('announcements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:10240' // Menerima Gambar / Video
        ]);

        $mediaPath = null;
        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('announcements', 'public');
        }

        Announcement::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'media_path' => $mediaPath,
        ]);

        return back()->with('alert-success', 'Pengumuman berhasil dibuat.');
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        if ($announcement->media_path) {
            Storage::disk('public')->delete($announcement->media_path);
        }
        $announcement->delete();

        return back()->with('alert-success', 'Pengumuman berhasil dihapus.');
    }
}
