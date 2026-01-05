<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Surat;
use Illuminate\Support\Facades\Log;

class BackfillSuratFilesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'surat:backfill-files {--dry : Do not write changes, just show what would be changed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan public surat files and backfill surat.file_surat where missing';

    public function handle()
    {
        $dry = $this->option('dry');

        $this->info('Scanning storage/app/public/surat for PDF files...');

        $files = [];
        if (Storage::disk('public')->exists('surat')) {
            $files = Storage::disk('public')->files('surat');
        } else {
            $this->warn('No surat directory found under public disk.');
            return 0;
        }

        $mapped = 0;
        $skipped = 0;

        foreach ($files as $file) {
            $basename = basename($file);

            // try patterns: surat_{id}_*.pdf or surat_{id}.pdf
            if (preg_match('/^surat_(\d+)(?:_|\.)?.*\.pdf$/i', $basename, $m)) {
                $id = (int)$m[1];
                $surat = Surat::find($id);
                if (!$surat) {
                    $this->line("File {$basename}: surat id {$id} not found in DB - skipping");
                    $skipped++;
                    continue;
                }

                // if DB already has a file and that file exists, skip
                if ($surat->file_surat && Storage::disk('public')->exists($surat->file_surat)) {
                    $this->line("Surat {$id}: already has file {$surat->file_surat} - skipping");
                    $skipped++;
                    continue;
                }

                $this->line("Will set surat.{$id}.file_surat = {$file}");
                if (!$dry) {
                    try {
                        $surat->file_surat = $file;
                        $surat->save();
                        $mapped++;
                    } catch (\Exception $e) {
                        Log::error('Failed to backfill file_surat for surat ' . $id . ': ' . $e->getMessage());
                        $this->error('Failed to update surat ' . $id . ': ' . $e->getMessage());
                    }
                }
            } else {
                $this->line("File {$basename}: pattern not recognized - skipping");
                $skipped++;
            }
        }

        $this->info("Done. Mapped: {$mapped}, Skipped: {$skipped}");

        return 0;
    }
}
