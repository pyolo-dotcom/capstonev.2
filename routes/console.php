<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Http\Controllers\FlespiFetchController;
use Symfony\Component\Console\Input\InputOption;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('flespi:fetch', function () {
    $count = $this->option('count');
    $controller = new FlespiFetchController();
    $result = $controller->fetchNewData(
        env('FLESPI_DEVICE_ID'), 
        env('FLESPI_TOKEN'),
        $count ? (int)$count : 100
    );
    $this->info("Fetched {$result['total']} messages, stored {$result['stored']} new messages");
})->purpose('Fetch new data from Flespi API')
  ->addOption('count', null, InputOption::VALUE_OPTIONAL, 'Number of messages to fetch', 100);

Artisan::command('flespi:batch-process', function () {
    $count = $this->option('count');
    $device = $this->option('device');
    
    $this->info("Processing batch of {$count} messages for device {$device}");
    // Add your batch processing logic here
})->purpose('Handle batch processing during Flespi data storage')
  ->addOption('count', null, InputOption::VALUE_REQUIRED, 'Number of messages in batch')
  ->addOption('device', null, InputOption::VALUE_REQUIRED, 'Device ID being processed');

Artisan::command('flespi:post-process', function () {
    $total = $this->option('total');
    $device = $this->option('device');
    
    $this->info("Post-processing {$total} stored messages for device {$device}");
    // Add your post-processing logic here
})->purpose('Handle post-processing after Flespi data storage')
  ->addOption('total', null, InputOption::VALUE_REQUIRED, 'Total messages processed')
  ->addOption('device', null, InputOption::VALUE_REQUIRED, 'Device ID being processed');

Schedule::command('flespi:fetch')
    ->name('flespi-fetch-schedule')
    ->everyMinute()
    ->withoutOverlapping(10)
    ->appendOutputTo(storage_path('logs/scheduler.log'))
    ->before(function () {
        \Log::info('======== STARTING FLESPI FETCH ========');
    })
    ->onSuccess(function () {
        \Log::info('Flespi fetch completed successfully');
    })
    ->onFailure(function () {
        \Log::error('Flespi fetch failed');
    });

Schedule::command('schedule:monitor')
    ->name('schedule-monitor-task')
    ->everyMinute()
    ->appendOutputTo(storage_path('logs/scheduler-monitor.log'));