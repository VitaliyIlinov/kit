<?php

namespace App\Console\Commands;

use App\Helpers\FileTools;
use App\Models\Course;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportBestRates extends Command
{
    public const COMMAND_NAME = 'app:import-best-rates';

    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = self::COMMAND_NAME;

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Import best rates';

    protected string $url;

    private FileTools $fileTools;

    protected function configure(): void
    {
        $this->url = config('services.best-change.url');
        $this->fileTools = app(FileTools::class);
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dirPath = $this->fileTools->unzip(
            $this->fileTools->download($this->url)
        );
        $this->fileTools->updateOrCreateSymbols($dirPath . '/bm_cycodes.dat');
        $data = $this->fileTools->getRate($dirPath . '/bm_rates.dat');

        $bar = $this->output->createProgressBar(count($data));

        $bar->start();

        foreach ($data as $from => $toItems) {
            foreach ($toItems as $to => $bestRate) {
                Course::updateOrCreate([
                    'from' => $from,
                    'to' => $to,
                ], [
                    'best_rate' => $bestRate,
                ]);
            }

            $bar->advance();
        }

        $bar->finish();
    }
}
