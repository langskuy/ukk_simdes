<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\FirebaseService;

class SuratController extends Controller
{
    /**
     * Tampilkan daftar jenis surat desa (publik).
     */


    /**
     * Tampilkan form pengajuan surat (auth required).
     * Default fallback ke halaman umum
     */
    /**
     * Tampilkan form pengajuan surat (auth required).
     * Default fallback ke halaman umum
     */
    public function create()
    {
        // if ($this->hasPendingSurat()) {
        //     return redirect()->route('surat.history')->with('error', 'Anda masih memiliki surat yang sedang diajukan. Harap tunggu hingga diproses admin.');
        // }
        return view('surat.create');
    }

    public function createUsaha()
    {
        return redirect()->route('surat.create', ['jenis_surat' => 'Surat Keterangan Usaha']);
    }

    public function createDomisili()
    {
        return redirect()->route('surat.create', ['jenis_surat' => 'Surat Keterangan Domisili']);
    }

    public function createTidakMampu()
    {
        return redirect()->route('surat.create', ['jenis_surat' => 'Surat Keterangan Tidak Mampu']);
    }

    public function createPindah()
    {
        return redirect()->route('surat.create', ['jenis_surat' => 'Surat Keterangan Pindah']);
    }

    public function createKelahiran()
    {
        return redirect()->route('surat.create', ['jenis_surat' => 'Surat Keterangan Kelahiran']);
    }

    public function createSkck()
    {
        return redirect()->route('surat.create', ['jenis_surat' => 'Surat Pengantar SKCK']);
    }

    /**
     * Simpan pengajuan surat ke database.
     */
    public function store(Request $request)
    {
        // if ($this->hasPendingSurat()) {
        //     return redirect()->route('surat.history')->with('error', 'Anda masih memiliki surat yang sedang diajukan.');
        // }

        // 1. Validasi Dasar
        $rules = [
            'jenis_surat' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:1000',
            // File Uploads
            'files.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // Max 2MB per file
        ];

        // 2. Validasi Dinamis Berdasarkan Jenis Surat (Opsional - Backend Validation Layer)
// Kita bisa menambahkan aturan spesifik jika diperlukan, tapi validasi frontend sudah cukup ketat.
// Untuk keamanan ekstra, kita bisa cek required fields di sini.
        $jenis = $request->jenis_surat;

        if ($jenis == 'Surat Keterangan Usaha') {
            $rules['nama_usaha'] = 'required|string|max:255';
            $rules['jenis_usaha'] = 'required|string|max:255';
            $rules['alamat_usaha'] = 'required|string|max:500';
            $rules['lama_usaha'] = 'required|string|max:255';
            $rules['modal_usaha'] = 'nullable|string|max:255';
            $rules['penghasilan_bulanan'] = 'nullable|string|max:255';
        } elseif ($jenis == 'Surat Keterangan Domisili') {
            $rules['alamat_domisili'] = 'required|string|max:500';
            $rules['lama_tinggal'] = 'required|string|max:255';
            $rules['keperluan'] = 'required|string|max:255';
        } elseif ($jenis == 'Surat Keterangan Tidak Mampu') {
            $rules['penghasilan_bulanan'] = 'required|string|max:255';
            $rules['keperluan'] = 'required|string|max:255';
            $rules['data_keluarga'] = 'required|string';
        } elseif ($jenis == 'Surat Keterangan Pindah') {
            $rules['alamat_tujuan'] = 'required|string|max:500';
            $rules['alasan_pindah'] = 'required|string|max:255';
            $rules['jumlah_pengikut'] = 'required|integer|min:0';
            $rules['daftar_pengikut'] = 'nullable|string';
        } elseif ($jenis == 'Surat Keterangan Kelahiran') {
            $rules['nama_anak'] = 'required|string|max:255';
            $rules['jenis_kelamin_anak'] = 'required|string';
            $rules['tempat_lahir_anak'] = 'required|string|max:255';
            $rules['tanggal_lahir_anak'] = 'required|date';
            $rules['waktu_lahir'] = 'required|string';
            $rules['anak_ke'] = 'required|integer|min:1';
            $rules['nama_ayah'] = 'required|string|max:255';
            $rules['nik_ayah'] = 'required|string|max:20';
            $rules['ttl_ayah'] = 'required|string|max:255';
            $rules['pekerjaan_ayah'] = 'required|string|max:255';
            $rules['nama_ibu'] = 'required|string|max:255';
            $rules['nik_ibu'] = 'required|string|max:20';
            $rules['ttl_ibu'] = 'required|string|max:255';
            $rules['pekerjaan_ibu'] = 'required|string|max:255';
            $rules['alamat_ortu'] = 'required|string|max:500';
        } elseif ($jenis == 'Surat Pengantar SKCK') {
            $rules['keperluan'] = 'required|string|max:255';
        }

        $validated = $request->validate($rules);

        $user = Auth::user();

        // 3. Handle File Uploads
        $lampiranPaths = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $key => $file) {
                // Simpan di storage/app/public/lampiran_surat
                $path = $file->store('lampiran_surat', 'public');
                $lampiranPaths[$key] = $path; // Key sesuai input name (ktp, kk, dll)
            }
        }

        // 4. Prepare Data
        $suratData = [
            'user_id' => $user ? $user->id : null,
            'nama_pemohon' => $user ? $user->name : ($validated['nama_pemohon'] ?? 'Pemohon'),
            'nik' => $request->nik ?? $user->nik, // Prioritas input user jika ada perubahan
            'no_hp' => $request->no_hp ?? $user->no_hp,
            'jenis_surat' => $validated['jenis_surat'],
            'status' => 'diajukan',
            'lampiran' => !empty($lampiranPaths) ? $lampiranPaths : null, // Casted to array via Model
        ];

        // 5. Kumpulkan Keterangan Detail (Gabung semua input field dinamis)
        $excludeFields = ['_token', 'jenis_surat', 'files', 'nik', 'no_hp', 'keterangan'];
        $detailData = $request->except($excludeFields);

        // Bersihkan null values
        $detailData = array_filter($detailData, function ($value) {
            return !is_null($value) && $value !== '';
        });

        if (!empty($detailData)) {
            $suratData['keterangan'] = json_encode($detailData, JSON_UNESCAPED_UNICODE);
        } else {
            $suratData['keterangan'] = $request->keterangan;
        }

        // Simpan note tambahan terpisah jika perlu, atau gabung ke json
        if ($request->keterangan) {
            // Jika keterangan sudah JD JSON, kita decode dulu, tambah field, encode lagi
// Atau simpelnya: Jika detailData ada, masukkan request->keterangan sebagai field 'catatan_tambahan'
            if (!empty($detailData)) {
                $detailData['catatan_tambahan'] = $request->keterangan;
                $suratData['keterangan'] = json_encode($detailData, JSON_UNESCAPED_UNICODE);
            }
        }

        try {
            $surat = Surat::create($suratData);

            // Create Local Activity Log
            ActivityLog::create([
                'user_id' => $user->id,
                'activity_type' => 'permohonan',
                'description' => "Mengajukan {$surat->jenis_surat}",
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            // Push notification & activity to Firebase
            try {
                $firebase = new FirebaseService();
                $firebase->pushNotification('surat', [
                    'id' => $surat->id,
                    'title' => 'Permohonan Surat Baru',
                    'message' => "{$surat->nama_pemohon} mengajukan {$surat->jenis_surat}",
                    'sender' => $surat->nama_pemohon
                ]);
            } catch (\Exception $fe) {
                Log::error('Firebase Notification Failed: ' . $fe->getMessage());
            }

            return redirect()->route('surat.thanks');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan Surat: ' . $e->getMessage(), [
                'data' => $suratData,
                'exception' => $e,
            ]);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat mengajukan surat. Error: ' .
                $e->getMessage());
        }

        return redirect()->route('surat.history')->with('success', 'Pengajuan surat berhasil dikirim! Silakan pantau status
pengajuan di sini.');
    }

    /**
     * Check if user has pending surat
     */
    private function hasPendingSurat()
    {
        return Surat::where('user_id', Auth::id())
            ->where('status', 'diajukan')
            ->exists();
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
                    Log::warning('PDF generated but DB save failed for surat ' . $surat->id . ': ' . $e->getMessage());
                    // Continue with download anyway - file is in public_path
                }
            } else {
                $errorMessage = session('pdf_error') ?: 'File surat belum tersedia. Silakan coba beberapa saat lagi.';
                return redirect()->back()->with('error', $errorMessage);
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

        // Detect mimetype for serving
        $mime = 'application/octet-stream';
        if (file_exists($path)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $path);
            finfo_close($finfo);
        }

        if ($inline) {
            // Return file to be displayed inline in browser with proper header
            return response()->file($path, [
                'Content-Type' => $mime,
            ]);
        }

        // Default: force download
        return response()->download($path, $filename);
    }

    /**
     * Batalkan pengajuan surat (Hapus dari DB).
     * Hanya bisa dilakukan jika status masih 'diajukan'.
     */
    public function destroy($id)
    {
        $surat = Surat::where('user_id', Auth::id())->findOrFail($id);

        if ($surat->status !== 'diajukan') {
            return back()->with('error', 'Hanya pengajuan dengan status "diajukan" yang bisa dibatalkan.');
        }

        // Hapus file lampiran jika ada
        if ($surat->lampiran) {
            foreach ($surat->lampiran as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        $surat->delete();

        return redirect()->route('surat.history')->with('success', 'Pengajuan surat berhasil dibatalkan.');
    }

    /**
     * Verifikasi keaslian surat via QR Code.
     * Route publik.
     */
    public function verify($id)
    {
        $surat = Surat::findOrFail($id);
        $village = json_decode(Storage::disk('app')->get('desa.json'), true);

        return view('surat.verify', compact('surat', 'village'));
    }
}