<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetTotalDistance extends Command
{
    protected $signature = 'distance:reset';
    protected $description = 'Reset total distance for all trucks every 24 hours';

    public function handle()
    {
        DB::table('trackings')
            ->whereDate('updated_at', '<', now()->toDateString()) // Reset if last update was before today
            ->update(['total_distance' => 0, 'updated_at' => now()]);

        $this->info('Total distances reset successfully.');
    }
}

