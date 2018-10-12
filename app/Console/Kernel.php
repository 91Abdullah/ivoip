<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use PAMI\Message\Action\CommandAction;
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
                    $manager->send($action);

                }
                $action1 = new CommandAction("core reload");
                $action2 = new CommandAction("module reload res_odbc.so");
                $action3 = new CommandAction("module load chan_sip.so");

                $manager->send($action1);
                $manager->send($action2);
                $manager->send($action3);

                $manager->close();
            })//->dailyAt('23:59');
            ->everyMinute();
        }
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
