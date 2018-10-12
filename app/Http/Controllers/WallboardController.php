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
    		// return dd($res1->getEvents())[0];
    		return response()->json([$res1->getEvents()[0]->getKeys(), $res2->getEvents()[0]->getKeys()], 200);

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

            foreach ($tableData as $key => $tableDatum) {
                if($key !== 0 && $key !== count($tableData) - 1) {
                    $processed->push([
                        "Name" => $tableDatum->getKey('name'),
                        "CallsTaken" => $tableDatum->getKey('callstaken'),
                        "LastCall" => $tableDatum->getKey('lastcall') == 0 ? 0 : Carbon::createFromTimestamp($tableDatum->getKey('lastcall'))->diffForHumans(),
                        "LastPause" => $tableDatum->getKey('lastpause') == 0 ? 0 : Carbon::createFromTimestamp($tableDatum->getKey('lastpause'))->diffForHumans(),
                        "PausedReason" => $tableDatum->getKey('pausedreason'),
                        "Status" => $tableDatum->getKey('status')
                    ]);
                }
            }

            return DataTables::of($processed->all())->toJson();
        } catch (\Exception $e) {
            return DataTables::of(new Collection())->toJson();
        }
    }
}
