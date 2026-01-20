<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use App\Models\Kegiatan;
use App\Models\Keuangan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $surats = Surat::where('user_id', $user->id)->latest()->take(8)->get();
        $kegiatanList = Kegiatan::latest()->take(4)->get();

        // Calculate statistics for Surat
        $totalSurat = Surat::where('user_id', $user->id)->count();
        $diajukan = Surat::where('user_id', $user->id)->where('status', 'diajukan')->count();
        $selesai = Surat::where('user_id', $user->id)->where('status', 'selesai')->count();
        $ditolak = Surat::where('user_id', $user->id)->where('status', 'ditolak')->count();
        $totalKegiatan = Kegiatan::count();

        // Keuangan Transparansi (Ringkasan Saja)
        // Hitung total semua waktu saja untuk ringkasan global
        $pemasukan = Keuangan::where('jenis', 'pemasukan')->sum('nominal');
        $pengeluaran = Keuangan::where('jenis', 'pengeluaran')->sum('nominal');
        $saldo = $pemasukan - $pengeluaran;

        return view('warga.dashboard', compact(
            'surats',
            'kegiatanList',
            'totalSurat',
            'diajukan',
            'selesai',
            'ditolak',
            'totalKegiatan',
            'pemasukan',
            'pengeluaran',
            'saldo'
        ));
    }
}
