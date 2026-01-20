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

            // Template Selection
            // Uses unified 'universal' template for all types to ensure consistency.
            // The universal.blade.php handles specific sections based on $surat->jenis_surat.
            $viewName = 'surat.templates.universal';

            // Use the official logo-desa.png from public/images
            $logoBase64 = null;
            $logoPaths = [
                public_path('images/logo-desa.png'),
                base_path('public/images/logo-desa.png'),
                public_path('logo-desa.png'),
            ];

            foreach ($logoPaths as $path) {
                if (file_exists($path)) {
                    try {
                        $content = file_get_contents($path);
                        $logoBase64 = 'data:image/png;base64,' . base64_encode($content);
                        break;
                    } catch (\Exception $e) {
                        Log::warning('Failed to load logo from ' . $path . ': ' . $e->getMessage());
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

            // Data Normalization (ensure common keys exist or have fallbacks)
            $kObj['no_kk'] = $kObj['no_kk'] ?? $surat->user->no_kk ?? '—';
            $kObj['jenis_kelamin'] = $kObj['jenis_kelamin'] ?? '—';
            $kObj['tempat_lahir'] = $kObj['tempat_lahir'] ?? '—';
            $kObj['tanggal_lahir'] = $kObj['tanggal_lahir'] ?? '—';
            $kObj['kewarganegaraan'] = $kObj['kewarganegaraan'] ?? 'WNI';
            $kObj['agama'] = $kObj['agama'] ?? '—';
            $kObj['pekerjaan'] = $kObj['pekerjaan'] ?? '—';
            $kObj['status_perkawinan'] = $kObj['status_perkawinan'] ?? $kObj['status_nikah'] ?? '—';
            $kObj['alamat'] = $kObj['alamat_asal'] ?? $kObj['alamat_lengkap'] ?? $kObj['alamat'] ?? '—';

            // Combine RT/RW if provided separately
            if (isset($kObj['rt']) && isset($kObj['rw'])) {
                $kObj['rt_rw'] = 'RT. ' . str_pad($kObj['rt'], 3, '0', STR_PAD_LEFT) . ' / RW. ' . str_pad($kObj['rw'], 3, '0', STR_PAD_LEFT);
            } else {
                $kObj['rt_rw'] = $kObj['rt_rw'] ?? '—';
            }

            // Generate Verification URL for QR Code
            $verifyUrl = route('surat.verify', ['id' => $surat->id]);

            // Generate QR Code: Try Local First, Fallback to Remote
            $qrBase64 = null;

            // 1. Try Local Generation (simplesoftwareio/simple-qrcode)
            // WE USE SVG NOW: It doesn't require ImageMagick/GD dependencies.
            try {
                if (class_exists(\SimpleSoftwareIO\QrCode\Facades\QrCode::class)) {
                    // generate() returns the SVG string content by default or with format('svg')
                    $qrRaw = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(150)->generate($verifyUrl);

                    if ($qrRaw) {
                        // Use svg+xml mime type
                        $qrBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrRaw);
                        Log::info("Local QR (SVG) generated successfully for Surat {$surat->id}");
                    }
                }
            } catch (\Exception $e) {
                Log::warning("Local QR (SVG) failed: " . $e->getMessage());
            }

            // 2. Fallback to Remote API if Local failed or returned null
            if (!$qrBase64) {
                $qrApiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($verifyUrl);
                try {
                    $ctx = stream_context_create(['http' => ['timeout' => 5]]);
                    $qrContent = @file_get_contents($qrApiUrl, false, $ctx);
                    if ($qrContent !== false) {
                        $qrBase64 = 'data:image/png;base64,' . base64_encode($qrContent);
                    } else {
                        Log::warning("Failed to fetch Remote QR Code for surat {$surat->id}");
                    }
                } catch (\Exception $e) {
                    Log::warning("Remote QR Code generation error: " . $e->getMessage());
                }
            }

            // Render HTML template (pass logo_base64 and parsed data to views)
            $html = View::make($viewName, [
                'surat' => $surat,
                'village' => $villageData,
                'logo_base64' => $logoBase64,
                'qr_code' => $qrBase64, // Pass Base64 QR Code
                'kObj' => $kObj, // Pass parsed keterangan data
            ])->render();

            // Generate PDF using DomPDF
            $pdf = Pdf::loadHTML($html)
                ->setPaper('a4')
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', true);

            // Check if GD is required but missing (DomPDF needs it for images)
            if (!extension_loaded('gd') && !empty($logoBase64)) {
                throw new \Exception('PHP GD extension is required to process the logo in PDFs. Please enable it in php.ini and restart Apache.');
            }

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
            // Store the error message in a way the controller can access it if needed
            session()->flash('pdf_error', $e->getMessage());
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
            $name = $data['nama_desa'] ?? $data['nama'] ?? 'Wonokasian';
            $normalized['nama_desa'] = preg_replace('/^desa\s+/i', '', $name);
            $normalized['kecamatan'] = $data['kecamatan'] ?? '';
            $normalized['kabupaten'] = $data['kabupaten'] ?? '';
            $normalized['provinsi'] = $data['provinsi'] ?? '';

            // include other useful fields as-is
            $normalized = array_merge($normalized, $data);

            return $normalized;
        } catch (\Exception $e) {
            return [
                'nama_desa' => 'Wonokasian',
                'kecamatan' => 'Wonoayu',
                'kabupaten' => 'Sidoarjo',
                'provinsi' => 'Jawa Timur',
            ];
        }
    }
}
