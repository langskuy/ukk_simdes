<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Surat;
use App\Services\SuratPdfGenerator;
use Illuminate\Support\Facades\Log;

class GenerateSuratPdfCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'surat:generate {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate PDF for a given Surat id and save file_surat on the model';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument('id');
        try {
            $surat = Surat::find($id);
            if (!$surat) {
                $this->error('Surat not found: ' . $id);
                return 1;
            }

            // avoid regenerating if file exists
            if ($surat->file_surat && \Illuminate\Support\Facades\Storage::disk('public')->exists($surat->file_surat)) {
                $this->info('File already exists for surat ' . $id);
                return 0;
            }

            $path = SuratPdfGenerator::generate($surat);
            if ($path) {
                $surat->file_surat = $path;
                $surat->save();
                $this->info('PDF generated: ' . $path);
                return 0;
            }

            $this->error('PDF generation failed for surat ' . $id);
            return 1;
        } catch (\Exception $e) {
            Log::error('GenerateSuratPdfCommand failed for surat ' . $id . ': ' . $e->getMessage());
            $this->error('Exception: ' . $e->getMessage());
            return 1;
        }
    }
}
