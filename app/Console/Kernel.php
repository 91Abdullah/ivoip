<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use PAMI\Message\Action\CommandAction;
use PAMI\Message\Action\ModuleCheckAction;
use PAMI\Message\Action\ModuleLoadAction;
use PAMI\Message\Action\ModuleReloadAction;
use Setting;
use PAMI\Message\Action\QueueResetAction;
use PAMI\Client\Impl\ClientImpl;
use App\Queue;

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
            $schedule->call(function () {
                $queues = Queue::all('name');
                $manager  = new ClientImpl($this->options());
                $manager->open();
                foreach ($queues as $queue) {

                    $action = new QueueResetAction($queue->name);
                    $response = $manager->send($action);
                    $this->info($response->getMessage());

                }

                $manager->close();
            })->dailyAt('23:59')
                ->appendOutputTo(storage_path("logs/daily.log"));
        }

        $schedule->call(function() {
            $client = new ClientImpl($this->options());
            $action = new ModuleReloadAction("res_odbc");
            $client->open();
            $response = $client->send($action);
            $this->info($response);
            $client->close();
        })->everyMinute()
            ->appendOutputTo(storage_path("logs/daily.log"));

        $schedule->call(function() {
            $client = new ClientImpl($this->options());
            $action = new ModuleCheckAction("chan_sip");
            $client->open();
            $response = $client->send($action);
            $this->info($response->getMessage());
            if($response->getKey('response') == "Error") {
                $action = new ModuleLoadAction("chan_sip");
                $response = $client->send($action);
                $this->error($response->getMessage());
            }
            $client->close();
        })->everyMinute()
            ->appendOutputTo(storage_path("logs/daily.log"));
    }

    private function options()
    {
        return $options = [
            // 'host' => '192.168.1.109',
            'host' => Setting::get('host'),
            'port' => (int)Setting::get('port'),
            'username' => Setting::get('username'),
            'secret' => Setting::get('secret'),
            'connect_timeout' => (int)Setting::get('connect_timeout'),
            'read_timeout' => (int)Setting::get('read_timeout'),
            'scheme' => 'tcp://' // try tls://
        ];
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
