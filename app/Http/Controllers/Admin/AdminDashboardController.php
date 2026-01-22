<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Kegiatan;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Check that user has admin role
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('warga.dashboard')->with('error', 'Akses ditolak: Anda tidak memiliki izin untuk halaman ini.');
        }

        $pengaduan_count = Pengaduan::count();
        $kegiatan_count = Kegiatan::count();
        $surat_count = Surat::count();
        $user_count = User::count();

        $pengaduan_new = Pengaduan::where('status', 'baru')->count();
        $surat_new = Surat::where('status', 'diajukan')->count();

        return view('admin.dashboard', compact(
            'pengaduan_count',
            'kegiatan_count',
            'surat_count',
            'user_count',
            'pengaduan_new',
            'surat_new'
        ));
    }
}
