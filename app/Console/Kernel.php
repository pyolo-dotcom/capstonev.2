<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('flespi:fetch')
            ->name('flespi-fetch-controller')
            ->everyMinute()
            ->withoutOverlapping(30)
            ->appendOutputTo(storage_path('logs/flespi-fetch.log'))
            ->before(function () {
                \Log::info('Starting Flespi fetch at '.now());
            })
            ->onSuccess(function () {
                \Log::info('Flespi fetch completed successfully at '.now());
            })
            ->onFailure(function () {
                \Log::error('Flespi fetch failed at '.now());
            });

        $schedule->command('schedule:monitor')
            ->name('schedule-monitor')
            ->everyMinute()
            ->appendOutputTo(storage_path('logs/scheduler-monitor.log'));
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}