<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use Illuminate\Http\Request;

class KeuanganAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Keuangan::query();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('keterangan', 'like', "%{$search}%")
                ->orWhere('kategori', 'like', "%{$search}%");
        }

        if ($request->has('jenis') && $request->jenis) {
            $query->where('jenis', $request->jenis);
        }

        $transaksi = $query->latest('tanggal')->paginate(15)->appends($request->query());

        // Statistik Ringkasan
        $pemasukan = Keuangan::where('jenis', 'pemasukan')->sum('nominal');
        $pengeluaran = Keuangan::where('jenis', 'pengeluaran')->sum('nominal');
        $saldo = $pemasukan - $pengeluaran;

        return view('admin.keuangan.index', compact('transaksi', 'pemasukan', 'pengeluaran', 'saldo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.keuangan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'kategori' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        Keuangan::create($validated);

        return redirect()->route('admin.keuangan.index')->with('success', 'Data transaksi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keuangan $keuangan)
    {
        return view('admin.keuangan.edit', compact('keuangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Keuangan $keuangan)
    {
        $validated = $request->validate([
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'kategori' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $keuangan->update($validated);

        return redirect()->route('admin.keuangan.index')->with('success', 'Data transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keuangan $keuangan)
    {
        $keuangan->delete();
        return redirect()->route('admin.keuangan.index')->with('success', 'Data transaksi berhasil dihapus.');
    }
}
