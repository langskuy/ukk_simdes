<?php

namespace App\Jobs;

use App\Models\Surat;
use App\Services\SuratPdfGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateSuratPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $suratId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($suratId)
    {
        $this->suratId = $suratId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $surat = Surat::find($this->suratId);
            if (!$surat) {
                return;
            }

            // Double-check if a file already exists
            if ($surat->file_surat && \Illuminate\Support\Facades\Storage::disk('public')->exists($surat->file_surat)) {
                return;
            }

            $path = SuratPdfGenerator::generate($surat);
            if ($path) {
                $surat->file_surat = $path;
                $surat->save();
            }
        } catch (\Exception $e) {
            Log::error('GenerateSuratPdf job failed for surat ' . $this->suratId . ': ' . $e->getMessage());
        }
    }
}
