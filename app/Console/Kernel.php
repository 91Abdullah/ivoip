<?php

namespace App\Console;

use App\Console\Commands\CoreReload;
use App\Console\Commands\ModuleCheckChanSip;
use App\Console\Commands\ModuleCheckOdbc;
use App\Console\Commands\ResetQueueStats;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Setting;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        if(Setting::get('reset_stats') == 'on') {
            $schedule->command(ResetQueueStats::class)->dailyAt('23:59')
                ->appendOutputTo(storage_path("logs/daily.log"));
        }

        $schedule->command(CoreReload::class)->everyFifteenMinutes()
            ->appendOutputTo(storage_path("logs/daily.log"));

        $schedule->command(ModuleCheckChanSip::class)->everyFifteenMinutes()
            ->appendOutputTo(storage_path("logs/daily.log"));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
