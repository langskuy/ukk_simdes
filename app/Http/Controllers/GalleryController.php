<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Show gallery/list of all pengaduan with status and lampiran
     */
    public function pengaduan(Request $request)
    {
        $query = Pengaduan::where('status', '!=', 'ditolak');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $pengaduans = $query->latest()->paginate(12);

        return view('gallery.pengaduan', compact('pengaduans'));
    }

    /**
     * Show detail pengaduan
     */
    public function showPengaduan($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // Check if visible (not new/rejected or is own pengaduan)
        if ($pengaduan->status === 'baru' || $pengaduan->status === 'ditolak') {
            if (!auth()->check() || auth()->id() !== $pengaduan->user_id) {
                abort(403, 'Pengaduan tidak dapat dilihat.');
            }
        }

        return view('gallery.pengaduan-detail', compact('pengaduan'));
    }

    /**
     * Show gallery/list of all kegiatan
     */
    public function kegiatan()
    {
        $kegiatans = Kegiatan::latest()->paginate(12);
        return view('gallery.kegiatan', compact('kegiatans'));
    }

    /**
     * Show detail kegiatan
     */
    public function showKegiatan($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        return view('gallery.kegiatan-detail', compact('kegiatan'));
    }

    /**
     * Show combined dashboard
     */
    public function dashboard()
    {
        $recentPengaduans = Pengaduan::where('status', '<>', 'baru')
            ->where('status', '<>', 'ditolak')
            ->latest()
            ->take(6)
            ->get();

        $recentKegiatans = Kegiatan::latest()->take(6)->get();

        return view('gallery.dashboard', compact('recentPengaduans', 'recentKegiatans'));
    }
}
