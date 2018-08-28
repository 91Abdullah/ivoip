<?php

use Illuminate\Foundation\Inspiring;
use PAMI\Message\Event\EventMessage;
use PAMI\Message\Event\AgentConnectEvent;
use App\Events\AgentConnectedEvent;
/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('event:start', function () {
	
	$options = array(
	    'host' => '10.0.0.217',
	    'scheme' => 'tcp://',
	    'port' => 5038,
	    'username' => 'manager_application',
	    'secret' => 'abdullah',
	    'connect_timeout' => 10,
	    'read_timeout' => 10
	);

	$client = new \PAMI\Client\Impl\ClientImpl($options);
	$client->open();

	// Registering a closure
	$client->registerEventListener(
		function (EventMessage $event) {
			$this->comment(var_export($event->getKeys()["interface"]));
			event(new AgentConnectedEvent($event));
		}, 
		function(EventMessage $event) {
			return $event instanceof AgentConnectEvent;
		}
	);

	$running = true;

	while ($running) {
		$client->process();
	}

	$client->close();
});
