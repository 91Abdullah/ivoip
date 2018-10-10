<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PAMI\Message\Action\QueuesAction;
use PAMI\Message\Action\QueueStatusAction;
use PAMI\Message\Action\QueueSummaryAction;
use PAMI\Client\Impl\ClientImpl;
use PAMI\Client\Exception\ClientException;
use Unisharp\Setting\Setting;

class WallboardController extends Controller
{
    public function get()
    {
    	try {
    		
    		$options = [
    			'host' => Setting::get('host'),
		        'port' => Setting::get('port'),
		        'username' => Setting::get('username'),
		        'secret' => Setting::get('secret'),
		        'connect_timeout' => Setting::get('connect_timeout'),
		        'read_timeout' => Setting::get('read_timeout'),
		        'scheme' => 'tcp://' // try tls://
    		];

    		$manager = new ClientImpl($options);
    		$manager->open();
    		$res1 = $manager->send(new QueueSummaryAction());
    		$res2 = $manager->send(new QueueStatusAction());
    		// return dd($res1->getEvents())[0];
    		return response()->json([$res1->getEvents()[0]->getKeys(), $res2->getEvents()[0]->getKeys()], 200);

    	} catch (ClientException $e) {
    		return response()->json("Error fetching record from server.", 400);
    	}
    }
}
