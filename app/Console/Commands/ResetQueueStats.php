<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Setting;
use PAMI\Message\Action\QueueResetAction;
use PAMI\Client\Impl\ClientImpl;
use App\Queue;

class ResetQueueStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:queues';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset Queue Stats';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $queues = Queue::all('name');
        $manager  = new ClientImpl($this->getAMIOptions());
        $manager->open();
        foreach ($queues as $queue) {

            $action = new QueueResetAction($queue->name);
            $response = $manager->send($action);
            $this->info($response->getMessage());

        }

        $manager->close();
    }

    private function getAMIOptions()
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
}
