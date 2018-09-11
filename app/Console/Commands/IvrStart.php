<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Setting;
use App\ListenerTest;

class IvrStart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ivr:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start IVR process';

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
        try {
            $options = array(
                'host' => Setting::get('host'),
                'port' => Setting::get('port'),
                'username' => Setting::get('username'),
                'secret' => Setting::get('secret'),
                'connect_timeout' => Setting::get('connect_timeout'),
                'read_timeout' => Setting::get('read_timeout'),
                'scheme' => 'tcp://' // try tls://
            );
            $listener = new ListenerTest($options);
            $listener->run();
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
        }
    }
}
