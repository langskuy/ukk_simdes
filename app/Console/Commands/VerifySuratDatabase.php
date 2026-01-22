<?php

namespace App\Console\Commands;

use App\Models\Surat;
use Illuminate\Console\Command;

class VerifySuratDatabase extends Command
{
    protected $signature = 'surat:verify-db {surat_id : The ID of the surat}';
    protected $description = 'Verify surat record in database';

    public function handle()
    {
        $suratId = $this->argument('surat_id');
        $surat = Surat::find($suratId);

        if (!$surat) {
            $this->error("Surat with ID {$suratId} not found");
            return 1;
        }

        $this->info("=== Surat Record ===");
        $this->line("ID: {$surat->id}");
        $this->line("Jenis: {$surat->jenis_surat}");
        $this->line("Pemohon: {$surat->nama_pemohon}");
        $this->line("NIK: {$surat->nik}");
        $this->line("Status: {$surat->status}");
        $this->line("File Surat: " . ($surat->file_surat ?: "NULL"));
        $this->line("Created: {$surat->created_at}");
        $this->line("Updated: {$surat->updated_at}");

        if ($surat->file_surat && file_exists(public_path($surat->file_surat))) {
            $this->info("✓ File exists at: " . public_path($surat->file_surat));
            $this->line("File size: " . (filesize(public_path($surat->file_surat)) / 1024) . " KB");
        } elseif ($surat->file_surat) {
            $this->error("✗ File not found at: " . public_path($surat->file_surat));
        }

        return 0;
    }
}
