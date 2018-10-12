<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PAMI\Message\Action\ModuleReloadAction;
use PAMI\Client\Impl\ClientImpl;
use Setting;

class ModuleCheckOdbc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:odbc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check ODBC module';

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
        $action = new ModuleReloadAction("res_odbc");
        $client->open();
        $response = $client->send($action);
        $this->info("INFO: " . $response->getMessage());
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
