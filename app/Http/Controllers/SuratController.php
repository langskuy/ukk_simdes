<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SuratController extends Controller
{
    /**
     * Tampilkan daftar jenis surat desa (publik).
     */
    public function index()
    {
        return view('surat.index');
    }

    /**
     * Tampilkan form pengajuan surat (auth required).
     * Default fallback ke halaman umum
     */
    public function create()
    {
        return view('surat.create');
    }

    /**
     * Tampilkan form pengajuan Surat Keterangan Usaha
     */
    public function createUsaha()
    {
        return view('surat.form-usaha');
    }

    /**
     * Tampilkan form pengajuan Surat Keterangan Domisili
     */
    public function createDomisili()
    {
        return view('surat.form-domisili');
    }

    /**
     * Tampilkan form pengajuan Surat Keterangan Tidak Mampu
     */
    public function createTidakMampu()
    {
        return view('surat.form-tidak-mampu');
    }

    /**
     * Tampilkan form pengajuan Surat Keterangan Pindah
     */
    public function createPindah()
    {
        return view('surat.form-pindah');
    }

    /**
     * Tampilkan form pengajuan Surat Keterangan Kelahiran
     */
    public function createKelahiran()
    {
        return view('surat.form-kelahiran');
    }

    /**
     * Tampilkan form pengajuan Surat Keterangan Lainnya
     */
    public function createLainnya()
    {
        return view('surat.form-lainnya');
    }

    /**
     * Simpan pengajuan surat ke database.
     */
    public function store(Request $request)
    {
        // Validasi dasar (wajib untuk semua jenis surat)
        $validated = $request->validate([
            'jenis_surat' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:1000',
            // Field Surat Domisili Lengkap
            'nik' => 'nullable|string|max:16',
            'no_kk' => 'nullable|string|max:16',
            'no_hp' => 'nullable|string|max:15',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string|max:500',
            'rt_rw' => 'nullable|string|max:20',
            'kelurahan' => 'nullable|string|max:255',
            'lama_tinggal' => 'nullable|string|max:100',
            'status_rumah' => 'nullable|string|max:100',
            'jenis_rumah' => 'nullable|string|max:100',
            'luas_rumah' => 'nullable|string|max:50',
            'alamat_sebelumnya' => 'nullable|string|max:500',
            'alasan_pindah' => 'nullable|string|max:255',
            'tujuan' => 'nullable|string|max:255',
            // Field Surat Usaha
            'nama_usaha' => 'nullable|string|max:255',
            'jenis_usaha' => 'nullable|string|max:255',
            'alamat_usaha' => 'nullable|string|max:500',
            'tahun_berdiri' => 'nullable|integer|min:1900|max:2100',
            'modal_usaha' => 'nullable|string|max:255',
            'jumlah_karyawan' => 'nullable|integer|min:0',
            'skala_produksi' => 'nullable|string|max:100',
            // Field Surat Tidak Mampu
            'alasan_pengajuan' => 'nullable|string|max:255',
            'jumlah_anggota_keluarga' => 'nullable|integer',
            'pekerjaan' => 'nullable|string|max:255',
            'penghasilan_bulanan' => 'nullable|string|max:255',
            'kondisi_khusus' => 'nullable|string|max:500',
            'aset' => 'nullable|array',
            'aset.*' => 'nullable|string|max:100',
            // Field Surat Pindah
            'alamat_lama' => 'nullable|string|max:500',
            'desa_tujuan' => 'nullable|string|max:255',
            'kecamatan_tujuan' => 'nullable|string|max:255',
            'kabupaten_tujuan' => 'nullable|string|max:255',
            'provinsi_tujuan' => 'nullable|string|max:255',
            'alamat_baru' => 'nullable|string|max:500',
            'tanggal_pindah' => 'nullable|date',
            'lama_tinggal_lama' => 'nullable|string|max:100',
            'anggota_keluarga' => 'nullable|integer|min:0',
            // Field Surat Kelahiran
            'nama_anak' => 'nullable|string|max:255',
            'jenis_kelamin_anak' => 'nullable|string|max:20',
            'berat_lahir' => 'nullable|numeric|min:1000|max:6000',
            'panjang_lahir' => 'nullable|numeric|min:30|max:60',
            'nama_ibu' => 'nullable|string|max:255',
            'nama_ayah' => 'nullable|string|max:255',
            'nik_ibu' => 'nullable|string|max:16',
            'nik_ayah' => 'nullable|string|max:16',
            // Field Surat Lainnya
            'jenis_surat_khusus' => 'nullable|string|max:255',
            'detail_permintaan' => 'nullable|string|max:2000',
            'nama_lembaga' => 'nullable|string|max:255',
            'alamat_lembaga' => 'nullable|string|max:500',
            'kontak_lembaga' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        // Store basic data (guard if for some reason user is null)
        $suratData = [
            'user_id' => $user ? $user->id : null,
            'nama_pemohon' => $user ? $user->name : ($validated['nama_pemohon'] ?? 'Pemohon'),
            'nik' => $user->nik ?? ($validated['nik'] ?? null),
            'no_hp' => $user->no_hp ?? ($validated['no_hp'] ?? null),
            'jenis_surat' => $validated['jenis_surat'],
            'status' => 'diajukan',
        ];

        // Tambahkan keterangan dari form umum atau spesifik
        $keterangan = [];
        
        // Kumpulkan data spesifik berdasarkan jenis surat
        foreach ($validated as $key => $value) {
            if ($key !== 'jenis_surat' && $value !== null) {
                $keterangan[$key] = $value;
            }
        }

        // Convert ke JSON atau text format
        if (!empty($keterangan)) {
            $suratData['keterangan'] = json_encode($keterangan, JSON_UNESCAPED_UNICODE);
        } else {
            $suratData['keterangan'] = $validated['keterangan'] ?? null;
        }

        try {
            Surat::create($suratData);
        } catch (\Exception $e) {
            // Log the error and return a helpful message to user
            Log::error('Gagal menyimpan Surat: '.$e->getMessage(), [
                'data' => $suratData,
                'exception' => $e,
            ]);

            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat mengajukan surat. Mohon coba lagi atau hubungi admin. Error: '.$e->getMessage());
        }

        return redirect()->route('surat.thanks')->with('success', 'Pengajuan surat berhasil dikirim!');
    }

    /**
     * Tampilkan halaman terima kasih.
     */
    public function thanks()
    {
        return view('surat.thanks');
    }

    /**
     * Tampilkan riwayat pengajuan surat user.
     */
    public function history()
    {
        $user = Auth::user();
        $surats = Surat::where('user_id', $user->id)->latest()->paginate(10);
        return view('surat.history', compact('surats'));
    }

    /**
     * Download file surat yang sudah selesai diproses.
     */
    public function download(\Illuminate\Http\Request $request, $id)
    {
        $surat = Surat::findOrFail($id);

        // Cek otorisasi: hanya user pemilik atau admin yang bisa download
        if (Auth::id() !== $surat->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        // Cek apakah surat sudah selesai
        if ($surat->status !== 'selesai') {
            return redirect()->back()->with('error', 'Surat belum selesai diproses.');
        }

        // If file_surat missing, attempt on-demand generation (synchronous)
        if (!$surat->file_surat || !file_exists(public_path($surat->file_surat))) {
            $pdfPath = \App\Services\SuratPdfGenerator::generate($surat);
            if ($pdfPath) {
                $surat->file_surat = $pdfPath;
                try {
                    $surat->save();
                } catch (\Exception $e) {
                    Log::warning('PDF generated but DB save failed for surat '.$surat->id.': '.$e->getMessage());
                    // Continue with download anyway - file is in public_path
                }
            } else {
                return redirect()->back()->with('error', 'File surat belum tersedia. Silakan coba beberapa saat lagi.');
            }
        }

        // Determine inline (view) or attachment (download)
        $inline = $request->query('inline') || str_ends_with($request->path(), '/view');

        $path = public_path($surat->file_surat);
        $filename = "Surat_{$surat->jenis_surat}_{$surat->id}.pdf";

        // Validate file exists and is readable
        if (!file_exists($path) || !is_readable($path)) {
            return redirect()->back()->with('error', 'File surat tidak ditemukan atau tidak dapat dibaca.');
        }

        // Basic validation: ensure file starts with PDF header
        $fh = @fopen($path, 'rb');
        $isPdf = false;
        if ($fh) {
            $start = fread($fh, 5);
            fclose($fh);
            if ($start === "%PDF-") {
                $isPdf = true;
            }
        }

        if (! $isPdf) {
            return redirect()->back()->with('error', 'File surat tidak valid (bukan PDF) atau korup.');
        }

        if ($inline) {
            // Return file to be displayed inline in browser with proper header
            return response()->file($path, [
                'Content-Type' => 'application/pdf',
            ]);
        }

        // Default: force download
        return response()->download($path, $filename);
    }
}
