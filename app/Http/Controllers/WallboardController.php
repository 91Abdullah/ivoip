<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use PAMI\Message\Action\QueuesAction;
use PAMI\Message\Action\QueueStatusAction;
use PAMI\Message\Action\QueueSummaryAction;
use PAMI\Client\Impl\ClientImpl;
use PAMI\Client\Exception\ClientException;
use PAMI\Message\Event\QueueMemberEvent;
use PAMI\Message\Event\UnknownEvent;
use Setting;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Services\DataTable;

class WallboardController extends Controller
{
    public function get($queue = null)
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
            $res1 = $manager->send(new QueueSummaryAction($queue));
            $res2 = $manager->send(new QueueStatusAction($queue));

            $events = $res2->getEvents();
            $acwCount = 0;
            $outboundCount = 0;

            foreach ($events as $key => $event) {
                if($event instanceof QueueMemberEvent && $event->getKey('paused')) {
                    if($event->getKey('pausedreason') == "Wrapup-Start") {
                        $acwCount++;
                    } elseif ($event->getKey('pausedreason') == "Outbound-Start") {
                        $outboundCount++;
                    }

                }
            }

    		return response()->json([$res1->getEvents()[0]->getKeys(), $res2->getEvents()[0]->getKeys(), $acwCount, $outboundCount], 200);

    	} catch (ClientException $e) {
    		return response()->json("Error fetching record from server.", 400);
    	}
    }

    public function getTableData(Request $request)
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

            $res2 = $manager->send(new QueueStatusAction($request->queue));

            $tableData = $res2->getEvents();
            $processed = new Collection;

            //return dd($tableData);

            foreach ($tableData as $key => $tableDatum) {
                if($tableDatum instanceof QueueMemberEvent) {
                    $processed->push([
                        "Name" => $tableDatum->getKey('name'),
                        "CallsTaken" => $tableDatum->getKey('callstaken'),
                        "LastCall" => $tableDatum->getKey('lastcall') == 0 ? 0 : Carbon::createFromTimestamp($tableDatum->getKey('lastcall'))->diffForHumans(),
                        "LastPause" => $tableDatum->getKey('lastpause') == 0 ? 0 : Carbon::createFromTimestamp($tableDatum->getKey('lastpause'))->diffForHumans(),
                        "PausedReason" => $tableDatum->getKey('pausedreason'),
                        "Status" => $this->mapStatus($tableDatum->getKey('status'))
                    ]);
                }
            }

            return DataTables::of($processed->all())->toJson();
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
