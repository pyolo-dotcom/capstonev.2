<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\FetchFlespiData::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('flespi:fetch')
                 ->everyFiveMinutes()
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/flespi-fetch.log'))
                 ->before(function () {
                     Log::info('Attempting to run flespi:fetch at '.now());
                 });
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}