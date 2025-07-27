<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MonitorScheduler extends Command
{
    protected $signature = 'schedule:monitor';
    protected $description = 'Monitor scheduler activity';

    public function handle()
    {
        Log::info('Scheduler ping at '.now());
        $this->info('Scheduler monitor ping sent');
        return 0;
    }
}