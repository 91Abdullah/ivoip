<?php

namespace App\Http\Controllers;

use App\Cdr;
use App\QueueLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

use PAMI\Client\Impl\ClientImpl;
use PAMI\Message\Action\ModuleCheckAction;
use PAMI\Message\Action\ModuleLoadAction;
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
use PAMI\Message\Action\OriginateAction;
use PAMI\Message\Event\EventMessage;
use PAMI\Message\Event\AgentConnectEvent;
use PAMI\Message\Event\QueueMemberEvent;
use PAMI\Message\Event\CoreShowChannelEvent;
use Symfony\Component\HttpFoundation\StreamedResponse;
use React\EventLoop\Factory;
use App\Events\AgentConnectedEvent;
use Setting;
use App\OutboundWorkcode;
use Illuminate\Support\Collection;
use Yajra\DataTables\DataTables;

class AmiController extends Controller
{
    public $technology = "PJSIP";
    
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

    public function queue_login(Request $request)
    {
        // return dd($this->options()());
    	// return response()->json($this->options());
    	$queue = $request->queue;
    	$agent_name = $request->agent_name;
    	$agent_interface = $this->technology . "/" . $request->agent_interface;

    	try {
    		$manager = new ClientImpl($this->options());
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
    		$manager = new ClientImpl($this->options());
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
    		$manager = new ClientImpl($this->options());
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
    		$manager = new ClientImpl($this->options());
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
    		$manager = new ClientImpl($this->options());
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
            $manager = new ClientImpl($this->options());
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
            $manager = new ClientImpl($this->options());
            $connected = $request->connected;
            $action = new CoreShowChannelsAction();

            $manager->open();
            $response = $manager->send($action);
            $manager->close();

            $queue = null;
            $keys = null;

            // return dd($response->getEvents());

            foreach ($response->getEvents() as $key => $value) {
                // return dd(get_class($value));
                if(get_class($value) == "PAMI\Message\Event\CoreShowChannelEvent") {
                    $keys = $value->getKeys();
                    // return $keys;
                    //preg_match('/"'.preg_quote("PJSIP/1001", "/").'"/', $keys["channel"], $match);
                    // return dd($keys["channel"]);
                    if($keys["application"] == "Queue" && $keys["calleridnum"] == $connected || $keys["calleridname"] == $connected) {
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
    		$manager = new ClientImpl($this->options());
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
    		$manager = new ClientImpl($this->options());
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

            $manager = new ClientImpl($this->options());

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

            $manager = new ClientImpl($this->options());

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

            $manager = new ClientImpl($this->options());

            $manager->open();
            $response = $manager->send($action);
            $manager->close();

            return response()->json("Caller put on unHold", 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 200);
        }
    }

    public function supervisor_agents(Request $request)
    {
        $queue = $request->queue;
        $action = new QueueStatusAction();
        $manager = new ClientImpl($this->options());
        $manager->open();
        $response = $manager->send($action);
        // sleep(2);
        //$manager->close();
        $events = collect($response->getEvents())
        ->filter(function ($value, $key) {
            return $value instanceof QueueMemberEvent;
        })
        ->map(function ($item, $key) {
            return $item->getKeys();
        });
        
        // return dd($events->all());
        // return response()->json($events->all(), 200);
        return DataTables::of($events->all())->toJson();
    }

    public function supervisor_calls(Request $request)
    {
        $action = new CoreShowChannelsAction();
        $manager = new ClientImpl($this->options());
        $manager->open();
        $response = $manager->send($action);
        // sleep(2);
        //$manager->close();
        $events = collect($response->getEvents())
        ->filter(function ($value, $key) {
            return $value instanceof CoreShowChannelEvent;
        })
        ->map(function ($item, $key) {
            return $item->getKeys();
        });
        
        // return dd($events->all());
        // return response()->json($events->all(), 200);
        return DataTables::of($events->all())->toJson();
    }

    public function supervisor_spy(Request $request)
    {
        try {
            $manager = new ClientImpl($this->options());
            $action = new OriginateAction($this->technology . "/" . $request->extension);
            $action->setApplication("ChanSpy");
            $action->setData($request->channel . "," . $request->options);
            $action->setTimeout(10000);
            $action->setCallerID("Abdullah");
            $action->setAsync(true);
            $manager->open();
            $response = $manager->send($action);
            $manager->close();
            // return dd($response);
            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }

    public function websocket_demo(User $user)
    {
        $retries = 3;
        $client = new ClientImpl($this->options());
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
                   throw new RuntimeException('Exit from loop', 1, $e);
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
//        $retries = 3;
//        $client = new ClientImpl($this->options());
//        $loop = Factory::create();
//        $client->registerEventListener(function (EventMessage $event) {
//            $response = $this->prepareResponse($event->getKeys());
//            $response->send();
//        }, function (EventMessage $event) {
//            return $event instanceof AgentConnectEvent;
//        });
//        $client->open();
//        $loop->addPeriodicTimer(1, function() use ($client, $retries) {
//            try {
//                $client->process();
//            } catch (Exception $e) {
//                if ($retries-- <= 0) {
//                   throw new RuntimeException('Exit from loop', 1, $exc);
//               }
//               sleep(10);
//            }
//        });
//        $loop->run();

        $client = new ClientImpl($this->options());
        $action = new ModuleCheckAction("chan_sip");
        $client->open();
        $response = $client->send($action);
        if($response->getKey('response') == "Error") {
            $action = new ModuleLoadAction("chan_sip");
            $response = $client->send($action);
        }
        $client->close();
        return dd($response);


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

            $manager = new ClientImpl($this->options());

            $manager->open();
            $response = $manager->send($action);
            $manager->close();

            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }

    public function getQueueStats(Request $request)
    {
        try {
            $queue = $request->queue;
            $agent = $this->technology . "/" . $request->agent;
            $manager = new ClientImpl($this->options());
            $action = new QueueStatusAction($queue, $agent);
            $action2 = new QueueSummaryAction($queue);
            $manager->open();
            $response = $manager->send($action);
            $response2 = $manager->send($action2);
            $manager->close();
            
            

            $queueStats = [];
            $agentStats = [];

            $queueStats["calls"] = $response->getEvents()[0]->getKey("calls");
            $queueStats["answered"] = $response->getEvents()[0]->getKey("completed");
            $queueStats["talktime"] = $response->getEvents()[0]->getKey("talktime");
            $queueStats["waittime"] = $response->getEvents()[0]->getKey("holdtime");
            $queueStats["servicelevelperf2"] = $response->getEvents()[0]->getKey("servicelevelperf2");
            $queueStats["abandoned"] = $response->getEvents()[0]->getKey("abandoned");
            $queueStats["callers"] = $response2->getEvents()[0]->getKey("callers");
            $queueStats["maxtime"] = $response2->getEvents()[0]->getKey("longestholdtime");


            $agentStats["name"] = $response->getEvents()[1]->getKey("name");
            $agentStats["interface"] = explode("/", $response->getEvents()[1]->getKey("stateinterface"));
            $agentStats["callstaken"] = $response->getEvents()[1]->getKey("callstaken");
            $agentStats["lastcall"] = $response->getEvents()[1]->getKey("lastcall") == 0 ? 0 : Carbon::createFromTimestamp($response->getEvents()[1]->getKey("lastcall"))->diffForHumans();
            $agentStats["lastpause"] = $response->getEvents()[1]->getKey("lastpause") == 0 ? 0 : Carbon::createFromTimestamp($response->getEvents()[1]->getKey("lastpause"))->diffForHumans();
            $agentStats["status"] = $this->mapStatus($response->getEvents()[1]->getKey("status"));
            $agentStats["pausedreason"] = $response->getEvents()[1]->getKey("pausedreason");
            $agentStats["incall"] = $response->getEvents()[1]->getKey("incall") == 0 ? "false" : "true";
            $agentStats["paused"] = $response->getEvents()[1]->getKey("paused") == 0 ? "false" : "true";

//            return dd($response2->getEvents(), $response->getEvents());
            return response()->json(["agent" => $agentStats, "queue" => $queueStats], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }

    public function getAgentCalls(Request $request)
    {
        try {
            if($request->calls == "unanswered") {
                $calls = QueueLog::whereDate("time", Carbon::now()->format("Y-m-d"))
                    ->where("agent", $request->agent)
                    ->whereIn("event", ["RINGNOANSWER", "RINGCANCELED"])
                    ->get();

                $incompleteCalls = new Collection;

                foreach ($calls as $call) {
                    $incompleteCalls->push([
                        "time" => Carbon::parse($call->time)->toDateTimeString(),
                        "callid" => $call->callid,
                        "queue" => $call->queuename,
                        "agent" => $call->agent,
                        "ringtime" => number_format($call->data1/1000, 2)
                    ]);
                }

                return DataTables::of($incompleteCalls)->make(true);

            } elseif($request->calls == "answered") {
                $calls = QueueLog::whereDate("time", Carbon::now()->format("Y-m-d"))
                    ->where("agent", $request->agent)
                    ->whereIn("event", ["COMPLETEAGENT", "COMPLETECALLER"])
                    ->get();

                $completedCalls = new Collection;;

                foreach ($calls as $call) {
                    $completedCalls->push([
                        "time" => Carbon::parse($call->time)->toDateTimeString(),
                        "callid" => $call->callid,
                        "agent" => $call->agent,
                        "queue" => $call->queuename,
                        "holdtime" => $call->data1,
                        "calltime" => $call->data2,
                        "queue_pos" => $call->data3,
                    ]);
                }

                return DataTables::of($completedCalls)->make(true);
            } else {
                return response()->json("Invalid request.", 400);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 400);
        }
    }

    private function mapStatus($code)
    {
        switch ($code) {
            case "0":
                return "DEVICE_UNKNOWN";
                break;
            case "1":
                return "DEVICE_NOT_INUSE";
                break;
            case "2":
                return "DEVICE_BUSY";
                break;
            case "3":
                return "DEVICE_INVALID";
                break;
            case "4":
                return "DEVICE_UNAVAILABLE";
                break;
            case "5":
                return "DEVICE_RINGING";
                break;
            case "6":
                return "DEVICE_RINGINUSE";
                break;
            case "7":
                return "DEVICE_ONHOLD";
                break;
            default:
                break;
        }
    }
}
