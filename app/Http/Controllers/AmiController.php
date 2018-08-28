<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PAMI\Client\Impl\ClientImpl;
use PAMI\Message\Action\QueuePauseAction;
use PAMI\Message\Action\QueueRemoveAction;
use PAMI\Message\Action\QueueAddAction;
use PAMI\Message\Action\QueueUnpauseAction;
use PAMI\Message\Action\QueueLogAction;
use PAMI\Message\Action\QueueSummaryAction;
use PAMI\Message\Action\QueueStatusAction;
use PAMI\Message\Action\GetVarAction;
use PAMI\Message\Action\StatusAction;
use PAMI\Message\Action\CoreShowChannelsAction;
use PAMI\Message\Action\AgentsAction;
use PAMI\Message\Event\EventMessage;
use PAMI\Message\Event\AgentConnectEvent;
use Symfony\Component\HttpFoundation\StreamedResponse;
use React\EventLoop\Factory;
use App\Events\AgentConnectedEvent;

use App\OutboundWorkcode;

class AmiController extends Controller
{
	public $options = [
        // 'host' => '192.168.1.109',
		'host' => '10.0.0.217',
		'port' => 5038,
		'username' => 'manager_application',
		'secret' => 'abdullah',
		'connect_timeout' => 100,
        'read_timeout' => 100,
        'scheme' => 'tcp://' // try tls://
	];

	public $technology = "PJSIP";

    public function queue_login(Request $request)
    {
    	// return response()->json($this->options);
    	$queue = $request->queue;
    	$agent_name = $request->agent_name;
    	$agent_interface = $this->technology . "/" . $request->agent_interface;

    	try {
    		$manager = new ClientImpl($this->options);
    		$action = new QueueAddAction($queue, $agent_interface);
    		$action->setMemberName($agent_name);

    		$manager->open();
    		$manager->send($action);
    		$manager->close();

    		return response()->json("You are now logged in the queue(s)", 200);

    	} catch (Exception $e) {
    		return response()->json($e->getMessage(), 404);
    	}
    }

    public function queue_logout(Request $request)
    {
    	$queue = $request->queue;
    	$agent_name = $request->agent_name;
    	$agent_interface = $this->technology . "/" . $request->agent_interface;

    	try {
    		$manager = new ClientImpl($this->options);
    		$action = new QueueRemoveAction($queue, $agent_interface);

    		$manager->open();
    		$manager->send($action);
    		$manager->close();

    		return response()->json("You are now logged out of the queue(s)", 200);

    	} catch (Exception $e) {
    		return response()->json($e->getMessage(), 404);
    	}
    }

    public function queue_pause(Request $request)
    {
    	$queue = $request->queue;
    	$agent_interface = $request->agent_interface;
    	$reason = $request->reason;
    	$agent_interface = $this->technology . "/" . $request->agent_interface;

    	try {
    		$manager = new ClientImpl($this->options);
    		$action = new QueuePauseAction($agent_interface, $queue, $reason);

    		$manager->open();
    		$manager->send($action);
    		$manager->close();

    		return response()->json("You status is now 'Not Ready' in queue(s)", 200);

    	} catch (Exception $e) {
    		return response()->json($e->getMessage(), 404);
    	}
    }

    public function queue_unpause(Request $request)
    {
    	$queue = $request->queue;
    	$agent_name = $request->agent_name;
    	$reason = $request->reason;
    	$agent_interface = $this->technology . "/" . $request->agent_interface;

    	try {
    		$manager = new ClientImpl($this->options);
    		$action = new QueueUnpauseAction($agent_interface, $queue, $reason);

    		$manager->open();
    		$manager->send($action);
    		$manager->close();

    		return response()->json("You status is now 'Ready' in queue(s)", 200);

    	} catch (Exception $e) {
    		return response()->json($e->getMessage(), 404);
    	}
    }

    public function queue_agents(Request $request)
    {
    	try {
    		$manager = new ClientImpl($this->options);
    		$agent = $this->technology . "/" . $request->agent;
            $action = new QueueStatusAction("100", "PJSIP/1001");

    		$manager->open();
    		$response = $manager->send($action);
    		$manager->close();

    		return response()->json(dd($response->getEvents()), 200);

    	} catch (Exception $e) {
    		return response()->json($e->getMessage(), 404);
    	}
    }

    public function get_callid(Request $request)
    {
        try {
            $manager = new ClientImpl($this->options);
            $agent = $this->technology . "/" . $request->agent;
            $action = new CoreShowChannelsAction();

            $manager->open();
            $response = $manager->send($action);
            $manager->close();

            $uniqueid = null;
            $keys = null;

            foreach ($response->getEvents() as $key => $value) {
                // return dd(get_class($value));
                if(get_class($value) == "PAMI\Message\Event\CoreShowChannelEvent") {
                    $keys = $value->getKeys();
                    // return $keys;
                    //preg_match('/"'.preg_quote("PJSIP/1001", "/").'"/', $keys["channel"], $match);
                    // return dd($keys["channel"]);
                    if(stripos(strtolower($keys["channel"]), $agent) !== false) {
                        $uniqueid = $keys["linkedid"];
                    }
                }
            }

            return response()->json($uniqueid, 200);

        } catch (Exception $e) {
            return response()->json($e->getMessage(), 404);
        }
    }

    public function get_queue(Request $request)
    {
        try {
            $manager = new ClientImpl($this->options);
            $connected = $request->connected;
            $action = new CoreShowChannelsAction();

            $manager->open();
            $response = $manager->send($action);
            $manager->close();

            $queue = null;
            $keys = null;

            foreach ($response->getEvents() as $key => $value) {
                // return dd(get_class($value));
                if(get_class($value) == "PAMI\Message\Event\CoreShowChannelEvent") {
                    $keys = $value->getKeys();
                    // return $keys;
                    //preg_match('/"'.preg_quote("PJSIP/1001", "/").'"/', $keys["channel"], $match);
                    // return dd($keys["channel"]);
                    if($keys["application"] == "Queue" && $keys["calleridnum"] == $connected) {
                        $queue = $keys["applicationdata"];
                    }
                }
            }

            return response()->json($queue, 200);

        } catch (Exception $e) {
            return response()->json($e->getMessage(), 404);
        }
    }

    public function agent_status(Request $request)
    {
    	try {
    		$queue = $request->queue;
    		$agent = $this->technology . '/' . $request->agent_interface;
    		$manager = new ClientImpl($this->options);
    		$action = new QueueStatusAction($queue, $agent);

    		$manager->open();
    		$response = $manager->send($action);

    		$agent_detail = $response->getEvents();

    		return response()->json($agent_detail[1]->getKeys(), 200);

    	} catch (Exception $e) {
    		return response()->json($e->getMessage(), 404);
    	}
    }

    public function agent_stats(Request $request)
    {
    	try {
    		$queue = $request->queue;
    		$agent = $this->technology . '/' . $request->agent_interface;
    		$manager = new ClientImpl($this->options);
    		$action = new QueueStatusAction($queue, $agent);

    		$manager->open();
    		$response = $manager->send($action);

    		$result = $response->getEvents();
            $data = [];

            foreach ($result as $key => $value) {
                $data[$key] = $value->getKeys();
            }

    		return response()->json($data, 200);

    	} catch (Exception $e) {
    		return response()->json($e->getMessage(), 404);
    	}
    }

    public function agent_workcode(Request $request)
    {
        try {
            $uniqueid = $request->uniqueid;
            $queue = $request->queue;
            $event = "WORKCODE";
            $agent = $request->agent;
            $message = $request->workcode;

            $manager = new ClientImpl($this->options);

            $action = new QueueLogAction($queue, $event);
            $action->setMemberName($agent);
            $action->setMessage($message);
            $action->setUniqueId($uniqueid);

            $manager->open();
            $response = $manager->send($action);
            $manager->close();

            return response()->json("workcode has been dumped: $message", 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 200);
        }
    }

    public function out_workcode(Request $request)
    {
        try {
            $workcode = OutboundWorkcode::create($request->all());
            return response()->json("workcode has been dumped: $workcode->workcode", 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 200);
        }
    }

    public function agent_hold(Request $request)
    {
        try {
            $uniqueid = $request->uniqueid;
            $queue = $request->queue;
            $event = "HOLD";
            $agent = $request->agent;
            $action = new QueueLogAction($queue, $event);
            $action->setMemberName($agent);
            $action->setUniqueId($uniqueid);

            $manager = new ClientImpl($this->options);

            $manager->open();
            $response = $manager->send($action);
            $manager->close();

            return response()->json("Caller put on Hold", 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 200);
        }
    }

    public function agent_unhold(Request $request)
    {
        try {
            $uniqueid = $request->uniqueid;
            $queue = $request->queue;
            $event = "UNHOLD";
            $agent = $request->agent;
            $action = new QueueLogAction($queue, $event);
            $action->setMemberName($agent);
            $action->setUniqueId($uniqueid);

            $manager = new ClientImpl($this->options);

            $manager->open();
            $response = $manager->send($action);
            $manager->close();

            return response()->json("Caller put on unHold", 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 200);
        }
    }

    public function websocket_demo(User $user)
    {
        $retries = 3;
        $client = new ClientImpl($this->options);
        $loop = Factory::create();
        $client->registerEventListener(function (EventMessage $event) {
            $response = $this->prepareResponse($event->getKeys());
            $response->send();
        }, function (EventMessage $event) {
            return $event instanceof AgentConnectEvent;
        });
        $client->open();
        $loop->addPeriodicTimer(1, function() use ($client, $retries) {
            try {
                $client->process();
            } catch (Exception $e) {
                if ($retries-- <= 0) {
                   throw new RuntimeException('Exit from loop', 1, $exc);
               }
               sleep(10);
            }
        });
        $loop->run();
    }

    private function prepareResponse($data)
    {
        $response = new StreamedResponse();
        $response->setCallback(function () use ($data) {
            echo "retry: 100\n\n"; // no retry would default to 3 seconds.
            echo 'data: ' . json_encode($data) . "\n\n";
            ob_flush();
            flush();
        });
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('X-Accel-Buffering', 'no');
        $response->headers->set('Cache-Control', 'no-cache');
        return $response;
    }

    public function test_ami()
    {   
        $retries = 3;
        $client = new ClientImpl($this->options);
        $loop = Factory::create();
        $client->registerEventListener(function (EventMessage $event) {
            $response = $this->prepareResponse($event->getKeys());
            $response->send();
        }, function (EventMessage $event) {
            return $event instanceof AgentConnectEvent;
        });
        $client->open();
        $loop->addPeriodicTimer(1, function() use ($client, $retries) {
            try {
                $client->process();
            } catch (Exception $e) {
                if ($retries-- <= 0) {
                   throw new RuntimeException('Exit from loop', 1, $exc);
               }
               sleep(10);
            }
        });
        $loop->run();
    }

    public function test_events(Request $request)
    {
        // event(new AgentConnectedEvent("event"));
        try {
            $uniqueid = $request->uniqueid;
            $queue = $request->queue;
            $event = "WORKCODE";
            $agent = $request->agent;
            $message = $request->workcode;
            $action = new QueueLogAction($queue, $event);
            $action->setMemberName($agent);
            $action->setMessage($message);
            $action->setUniqueId($uniqueid);

            $manager = new ClientImpl($this->options);

            $manager->open();
            $response = $manager->send($action);
            $manager->close();

            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 200);
        }
    }
}
