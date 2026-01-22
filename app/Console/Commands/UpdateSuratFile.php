<?php

namespace App\Console\Commands;

use App\Models\Surat;
use App\Services\SuratPdfGenerator;
use Illuminate\Console\Command;

class UpdateSuratFile extends Command
{
    protected $signature = 'surat:update-file {surat_id : The ID of the surat}';
    protected $description = 'Generate and update PDF file path for a surat';

    public function handle()
    {
        $suratId = $this->argument('surat_id');
        $surat = Surat::find($suratId);

        if (!$surat) {
            $this->error("Surat with ID {$suratId} not found");
            return 1;
        }

        try {
            $this->info("Generating PDF for Surat ID: {$suratId}...");
            $path = SuratPdfGenerator::generate($surat);

            if ($path) {
                $surat->file_surat = $path;
                $surat->save();
                $this->info("✓ Successfully generated and saved");
                $this->line("File: {$path}");
                $this->line("Full path: " . public_path($path));
                return 0;
            } else {
                $this->error("✗ PDF generation returned null");
                return 1;
            }
        } catch (\Exception $e) {
            $this->error("✗ Error: " . $e->getMessage());
            return 1;
        }
    }
}
