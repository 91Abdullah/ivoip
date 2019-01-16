<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Console\Command;
use PAMI\Client\Impl\ClientImpl;
use PAMI\Message\Event\AgentConnectEvent;
use Setting;

class ApiPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to log incoming call data via API';

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
        $manager = new ClientImpl($this->getAMIOptions());
        try {
            $manager->registerEventListener(function ($event) {
                $agent = explode("/", $event->getKey('Interface'))[1];
                $phone = $event->getKey('CallerIDNum');
                $client = new Client([
                    'timeout' => 10
                ]);
                $response = $client->request('POST', 'http://192.168.0.79/Leop/api/UserProfiling/Add', [
                    'UserId' => $agent,
                    'PhoneNo' => $phone
                ]);
                $this->info($response->getBody());
            }, function ($event) {
                return $event instanceof AgentConnectEvent;
            });
        } catch (RequestException $e) {
            $this->info($e->getResponse());
        }
        $manager->open();
        while (true) {
            usleep(1000);
            $manager->process();
        }
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
