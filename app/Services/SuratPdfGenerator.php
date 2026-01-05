<?php

namespace App\Services;

use App\Models\Surat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;

class SuratPdfGenerator
{
    /**
     * Generate PDF from surat data and save to public/storage/surat/
     * Returns the public URL path to the PDF file
     */
    public static function generate(Surat $surat): ?string
    {
        try {
            // Get village data from desa.json or session
            $villageData = self::getVillageData();

            // Map jenis_surat to specific template file
            $templateMap = [
                'usaha' => 'usaha',
                'keterangan usaha' => 'usaha',
                'surat keterangan usaha' => 'usaha',
                'domisili' => 'domisili',
                'keterangan domisili' => 'domisili',
                'surat keterangan domisili' => 'domisili',
                'tidak_mampu' => 'tidak_mampu',
                'tidak mampu' => 'tidak_mampu',
                'keterangan tidak mampu' => 'tidak_mampu',
                'surat keterangan tidak mampu' => 'tidak_mampu',
                'pindah' => 'pindah',
                'keterangan pindah' => 'pindah',
                'surat keterangan pindah' => 'pindah',
                'kelahiran' => 'kelahiran',
                'keterangan kelahiran' => 'kelahiran',
                'surat keterangan kelahiran' => 'kelahiran',
                'lainnya' => 'lainnya',
                'keterangan lainnya' => 'lainnya',
                'surat keterangan lainnya' => 'lainnya',
            ];

            // Normalize jenis_surat and look up template
            $jenis = strtolower(trim($surat->jenis_surat ?? ''));
            $templateKey = $templateMap[$jenis] ?? 'official'; // Fallback to official if not found

            $viewName = 'surat.templates.' . $templateKey;

            // Try to read a logo from storage/public (logo.png|jpg|svg)
            $logoBase64 = null;
            foreach (['logo.png','logo.jpg','logo.jpeg','logo.svg'] as $logoFile) {
                if (Storage::disk('public')->exists($logoFile)) {
                    try {
                        $content = Storage::disk('public')->get($logoFile);
                        $ext = pathinfo($logoFile, PATHINFO_EXTENSION);
                        $mime = 'image/png';
                        if (in_array(strtolower($ext), ['jpg','jpeg'])) $mime = 'image/jpeg';
                        if (strtolower($ext) === 'svg') $mime = 'image/svg+xml';
                        $logoBase64 = 'data:' . $mime . ';base64,' . base64_encode($content);
                        break;
                    } catch (\Exception $e) {
                        // ignore and continue
                    }
                }
            }

            // Parse keterangan JSON to extract field data for template
            $kObj = [];
            if (!empty($surat->keterangan)) {
                try {
                    $kObj = is_array($surat->keterangan) ? $surat->keterangan : json_decode($surat->keterangan, true) ?? [];
                } catch (\Exception $e) {
                    $kObj = [];
                }
            }

            // Render HTML template (pass logo_base64 and parsed data to views)
            $html = View::make($viewName, [
                'surat' => $surat,
                'village' => $villageData,
                'logo_base64' => $logoBase64,
                'kObj' => $kObj, // Pass parsed keterangan data
            ])->render();

            // Generate PDF using DomPDF
            $pdf = Pdf::loadHTML($html)
                ->setPaper('a4')
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', true);

            // Create filename and save directly to public/storage/surat/
            $filename = 'surat_' . $surat->id . '_' . time() . '.pdf';
            $directory = public_path('storage/surat');
            
            // Ensure directory exists
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            $fullPath = $directory . '/' . $filename;
            file_put_contents($fullPath, $pdf->output());

            // Return public-accessible URL path
            return 'storage/surat/' . $filename;
        } catch (\Exception $e) {
            Log::error('Failed to generate PDF for surat ' . $surat->id . ': ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get village data from desa.json or return default
     */
    private static function getVillageData()
    {
        try {
            $json = Storage::disk('app')->get('desa.json');
            $data = json_decode($json, true) ?? [];

            // normalize keys expected by templates to avoid mismatches
            $normalized = [];
            $normalized['nama_desa'] = $data['nama_desa'] ?? $data['nama'] ?? null;
            $normalized['kecamatan'] = $data['kecamatan'] ?? '';
            $normalized['kabupaten'] = $data['kabupaten'] ?? '';
            $normalized['provinsi'] = $data['provinsi'] ?? '';
            
            // include other useful fields as-is
            $normalized = array_merge($normalized, $data);

            return $normalized;
        } catch (\Exception $e) {
            return [
                'nama_desa' => 'Desa Wonokasian',
                'kecamatan' => 'Wonoayu',
                'kabupaten' => 'Sidoarjo',
                'provinsi' => 'Jawa Timur',
            ];
        }
    }
}
