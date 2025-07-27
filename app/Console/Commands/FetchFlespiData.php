<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\FlespiFetchController;

class FetchFlespiData extends Command
{
    protected $signature = 'flespi:fetch {--retries=3 : Number of retry attempts}';
    protected $description = 'Fetch data from Flespi API and store in MySQL';

    public function handle()
    {
        $this->info("Starting Flespi data fetch...");
        
        try {
            $controller = new FlespiFetchController();
            $result = $controller->fetchAndStoreData(
                env('FLESPI_DEVICE_ID'),
                env('FLESPI_TOKEN')
            );
            
            $this->info("Successfully stored {$result['stored']} new messages out of {$result['total']} fetched.");
            return 0;
            
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            Log::error("Flespi fetch failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 1;
        }
    }
}