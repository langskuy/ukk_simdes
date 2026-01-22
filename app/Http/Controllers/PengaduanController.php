<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PengaduanController extends Controller
{
    /**
     * Show form to create a new pengaduan
     */
    public function create()
    {
        return view('pengaduan.create');
    }

    /**
     * Store submitted pengaduan
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_pelapor' => 'required|string|max:255',
            'nik' => 'nullable|string|max:30',
            'no_hp' => 'required|string|max:30',
            'judul' => 'required|string|max:255',
            'isi' => 'required|string|max:2000',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ]);

        // handle file upload
        $path = null;
        if ($request->hasFile('lampiran')) {
            $path = $request->file('lampiran')->store('pengaduan', 'public');
        }

        $pengaduan = Pengaduan::create([
            'user_id' => auth()->id(),
            'nama_pelapor' => $data['nama_pelapor'],
            'nik' => $data['nik'] ?? null,
            'no_hp' => $data['no_hp'],
            'judul' => $data['judul'],
            'isi' => $data['isi'],
            'lampiran' => $path,
            'status' => 'baru',
        ]);

        return redirect()->route('pengaduan.thanks');
    }

    /**
     * Thank you page after submission
     */
    public function thanks()
    {
        return view('pengaduan.thanks');
    }

    /**
     * Show logged-in user's pengaduan history
     */
    public function history()
    {
        $pengaduans = auth()->user()->pengaduans()->latest()->get();
        return view('pengaduan.history', compact('pengaduans'));
    }
}
