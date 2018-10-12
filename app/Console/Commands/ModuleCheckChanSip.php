<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PAMI\Message\Action\CommandAction;
use PAMI\Message\Action\ModuleCheckAction;
use PAMI\Message\Action\ModuleLoadAction;
use PAMI\Client\Impl\ClientImpl;
use Setting;

class ModuleCheckChanSip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:chan_sip';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check chan_sip Module';

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
        $client = new ClientImpl($this->getAMIOptions());
        $action = new ModuleCheckAction("chan_sip");
        $client->open();
        $response = $client->send($action);
        $this->info("INFO: " . $response->getMessage());
        if($response->getKey('response') == "Error") {
            $action = new ModuleLoadAction("chan_sip");
            $response = $client->send($action);
            $this->error("ERROR: " . $response->getMessage());
        }
        $client->close();
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
