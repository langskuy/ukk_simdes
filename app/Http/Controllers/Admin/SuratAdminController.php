<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Surat;
use Illuminate\Support\Facades\Storage;
use App\Services\SuratPdfGenerator;
use App\Jobs\GenerateSuratPdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

class SuratAdminController extends Controller
{
    public function index()
    {
        $surats = Surat::with('user')->paginate(15);
        return view('admin.surat.index', compact('surats'));
    }

    public function show($id)
    {
        $surat = Surat::with('user')->findOrFail($id);

        $fileMime = null;
        if ($surat->file_surat && Storage::disk('public')->exists($surat->file_surat)) {
            $path = Storage::disk('public')->path($surat->file_surat);
            if (file_exists($path)) {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $fileMime = finfo_file($finfo, $path);
                finfo_close($finfo);
            }
        }

        $fileIsPdf = ($fileMime === 'application/pdf');
        $fileIsImage = str_starts_with($fileMime ?? '', 'image/');

        return view('admin.surat.show', compact('surat', 'fileIsPdf', 'fileIsImage'));
    }

    public function update(Request $request, $id)
    {
        $surat = Surat::findOrFail($id);
        $validated = $request->validate([
            'status' => 'nullable|in:diajukan,diproses,selesai',
            'tanggal_selesai' => 'nullable|date',
            'file_surat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'generate_pdf' => 'nullable|boolean',
        ]);

        // Handle file upload
        if ($request->hasFile('file_surat')) {
            // Delete old file if exists
            if ($surat->file_surat && Storage::disk('public')->exists($surat->file_surat)) {
                Storage::disk('public')->delete($surat->file_surat);
            }

            // Store new file
            $file = $request->file('file_surat');
            $filename = 'surat/surat_' . $surat->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('surat', $file, basename($filename));
            $validated['file_surat'] = $path;
        }

        // Update model first
        $surat->update($validated);

        // If PDF generation was requested or status became 'selesai', ensure a file exists.
        $forceGenerate = $request->has('generate_pdf') && $request->generate_pdf == '1';
        $shouldGenerate = $forceGenerate || ($validated['status'] ?? null) === 'selesai';
        $hasFile = $surat->file_surat && Storage::disk('public')->exists($surat->file_surat);

        if ($shouldGenerate && (!$hasFile || $forceGenerate)) {
            // If the status is set to 'selesai', generate synchronously so warga can download immediately.
            // This intentionally generates synchronously to meet the requirement that the file
            // is immediately available after admin marks the surat as selesai.
            try {
                $pdfPath = SuratPdfGenerator::generate($surat);
                if ($pdfPath) {
                    $surat->file_surat = $pdfPath;
                    try {
                        $surat->save();
                        return redirect()->route('admin.surat.show', $surat)->with('success', 'Surat disimpan dan PDF sudah tersedia.');
                    } catch (\Exception $dbEx) {
                        // Database save failed (likely DB connection issue). Write manifest mapping as fallback
                        Log::warning('Failed to save file_surat to DB for surat ' . $surat->id . ': ' . $dbEx->getMessage());
                        try {
                            $manifestPath = 'surat/manifest.json';
                            $manifest = [];
                            if (Storage::disk('public')->exists($manifestPath)) {
                                $raw = Storage::disk('public')->get($manifestPath);
                                $manifest = json_decode($raw, true) ?? [];
                            }
                            $manifest[$surat->id] = $pdfPath;
                            Storage::disk('public')->put($manifestPath, json_encode($manifest, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
                        } catch (\Exception $mfEx) {
                            Log::error('Failed to write manifest for surat ' . $surat->id . ': ' . $mfEx->getMessage());
                        }

                        return redirect()->route('admin.surat.show', $surat)->with('warning', 'Surat disimpan, PDF dibuat tetapi tidak dapat menyimpan ke database — file tersimpan sementara.');
                    }
                }

                // If generation returned null, fall back to dispatching a job so worker can try.
                try {
                    GenerateSuratPdf::dispatch($surat->id);
                } catch (\Exception $e) {
                    try {
                        Artisan::call('surat:generate', ['id' => $surat->id]);
                    } catch (\Exception $ex) {
                        Log::error('Failed to queue fallback generate for surat ' . $surat->id, ['err' => $ex->getMessage()]);
                    }
                }

                return redirect()->route('admin.surat.show', $surat)->with('warning', 'Status disimpan. PDF belum berhasil dibuat, tetapi pekerjaan pembuatan telah dijadwalkan.');
            } catch (\Exception $e) {
                // If synchronous generation fails, log and dispatch background job as fallback.
                Log::error('Synchronous PDF generation failed for surat ' . $surat->id . ': ' . $e->getMessage());
                try {
                    GenerateSuratPdf::dispatch($surat->id);
                } catch (\Exception $ex) {
                    Log::error('Failed to dispatch GenerateSuratPdf fallback for surat ' . $surat->id . ': ' . $ex->getMessage());
                }

                return redirect()->route('admin.surat.show', $surat)->with('warning', 'Status disimpan. Terjadi kesalahan saat membuat PDF; pekerjaan pembuatan dijadwalkan.');
            }
        }

        return redirect()->route('admin.surat.show', $surat)->with('success', 'Surat berhasil diperbarui.');
    }

    /**
     * Delete surat and associated file.
     */
    public function destroy($id)
    {
        try {
            $surat = Surat::find($id);

            // If already deleted (idempotent), just redirect
            if (!$surat) {
                return redirect()->route('admin.surat.index')->with('success', 'Surat sudah tidak ada.');
            }

            // Delete file if exists (now in public/storage/)
            if ($surat->file_surat && file_exists(public_path($surat->file_surat))) {
                unlink(public_path($surat->file_surat));
            }

            $surat->delete();
            return redirect()->route('admin.surat.index')->with('success', 'Surat berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting Surat', ['id' => $id, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Gagal menghapus surat. Periksa log aplikasi.');
        }
    }
}
