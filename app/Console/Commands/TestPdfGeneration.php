<?php

namespace App\Console\Commands;

use App\Models\Surat;
use App\Services\SuratPdfGenerator;
use Illuminate\Console\Command;

class TestPdfGeneration extends Command
{
    protected $signature = 'surat:test-pdf {surat_id : The ID of the surat to test PDF generation}';
    protected $description = 'Test PDF generation for a specific surat';

    public function handle()
    {
        $suratId = $this->argument('surat_id');
        $surat = Surat::find($suratId);

        if (!$surat) {
            $this->error("Surat with ID {$suratId} not found");
            return 1;
        }

        $this->info("Testing PDF generation for Surat ID: {$suratId}");
        $this->info("Jenis Surat: {$surat->jenis_surat}");
        $this->info("Pemohon: {$surat->nama_pemohon}");

        // Check GD extension
        if (!extension_loaded('gd')) {
            $this->error("✗ GD Extension is NOT loaded");
            return 1;
        }
        $this->info("✓ GD Extension is loaded");

        // Try to generate PDF
        try {
            $this->info("Generating PDF...");
            $path = SuratPdfGenerator::generate($surat);

            if ($path) {
                $this->info("✓ PDF generated successfully");
                $this->info("Path: {$path}");
                $this->info("Full path: " . public_path($path));
                
                if (file_exists(public_path($path))) {
                    $this->info("✓ PDF file exists");
                    $fileSize = filesize(public_path($path));
                    $this->info("File size: " . ($fileSize / 1024) . " KB");
                } else {
                    $this->error("✗ PDF file not found at generated path");
                    return 1;
                }
            } else {
                $this->error("✗ PDF generation returned null");
                return 1;
            }
        } catch (\Exception $e) {
            $this->error("✗ PDF generation failed: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
