<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder; // import class on controller
use DataTables;
use App\User;
use App\QueueLog;
use App\Cdr;
use App\Queue;
use App\Role;
use App\Workcode;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Collection;

class ReportsController extends Controller
{
    public function index(Request $request, Builder $htmlBuilder)
    {
    	return view('reports.index');
    }

    public function getTrunkUtilization()
    {
    	return view('reports.trunk_utilization');
    }

    public function getTrunkUtilizationData(Request $request)
    {
    	$dt = new Carbon($request->date);
    	// $records = QueueLog::where("event", "ENTERQUEUE")->whereDate("created", $dt->format("Y-m-d"))->get()->groupBy(function ($data) {
    	// 	return Carbon::parse($data->created)->format("H");
    	// });

    	$records = Cdr::whereDate("start", $dt->format("Y-m-d"))->get()->groupBy(function ($data) {
    		return Carbon::parse($data->start)->format("H");
    	});

    	$processed = new Collection;

    	$hours = [];

    	for ($i=0; $i < 24; $i++) { 
    		$i = sprintf("%02d", $i);
    		$hours[$i] = 0;
    	}

    	foreach ($hours as $key => $value) {
    		if($records->has($key)) {
    			$processed->push([
    				"hour" => $key,
    				"count" => $records->get($key)->count()
    			]);
    		} else {
    			$processed->push([
    				"hour" => $key,
    				"count" => 0
    			]);
    		}
    		$i++;
		}	

    	return DataTables::of($processed)->toJson();
    }

    public function getTrunkUtilizationGraph()
    {
    	return view('reports.trunk_utilization_chart');
    }

    public function getTrunkUtilizationGraphData(Request $request)
    {
    	$dt = new Carbon($request->date);
    	$records = QueueLog::where("event", "ENTERQUEUE")->whereDate("created", $dt->format("Y-m-d"))->get()->groupBy(function ($data) {
    		return Carbon::parse($data->created)->format("H");
    	});

    	$processed = new Collection;

    	$hours = [];

    	for ($i=0; $i < 24; $i++) { 
    		$i = sprintf("%02d", $i);
    		$hours[$i] = 0;
    	}

    	foreach ($hours as $key => $value) {
    		if($records->has($key)) {
    			$processed->push([
    				"hour" => $key,
    				"count" => $records->get($key)->count()
    			]);
    		} else {
    			$processed->push([
    				"hour" => $key,
    				"count" => 0
    			]);
    		}
    		$i++;
		}	

    	return response()->json($processed, 200);
    }

    public function getHourlyServiceLevel()
    {
    	$queues  = Queue::pluck('name', 'name');
    	return view('reports.hourly_service_level', compact('queues'));
    }

    public function getHourlyServiceLevelData(Request $request)
    {
    	$dt = new Carbon($request->date);
    	$queue = Queue::findOrFail($request->queue);
    	$service_level = $queue->servicelevel;

    	$totalCalls = QueueLog::where([
    		["event", "ENTERQUEUE"],
    		["queuename", $queue->name]
    	])->whereDate("created", $dt->format("Y-m-d"))->get()->groupBy(function ($data) {
    		return Carbon::parse($data->created)->format("H");
    	});

    	$totalAnsweredCalls = QueueLog::where([
    		["event", "CONNECT"],
    		["queuename", $queue->name],
    		["data1", "<", $service_level]
    	])->whereDate("created", $dt->format("Y-m-d"))->get()->groupBy(function ($data) {
    		return Carbon::parse($data->created)->format("H");
    	});

    	$processed = new Collection;

    	$hours = [];

    	for ($i=0; $i < 24; $i++) { 
    		$i = sprintf("%02d", $i);
    		$hours[$i] = 0;
    	}

    	foreach ($hours as $key => $value) {

    		$totalProcessedCalls = $totalCalls->get($key) == null ? 0 : $totalCalls->get($key)->count();
    		$totalAnsweredtotalProcessedCalls = $totalAnsweredCalls->get($key) == null ? 0 : $totalAnsweredCalls->get($key)->count();
    		$totalPercent = $totalProcessedCalls == 0 ? number_format(100, 2, '.', '') : number_format((float)((int)$totalAnsweredtotalProcessedCalls/(int)$totalProcessedCalls) * 100, 2, '.', '');

    		$processed->push([
				"hour" => $key,
				"total" => $totalProcessedCalls,
				"answered" => $totalAnsweredtotalProcessedCalls,
				"count" => $totalPercent
			]);
    		
    		$i++;
		}

    	return DataTables::of($processed)->toJson();
    }

    public function getHourlyServiceLevelGraph()
    {
    	$queues  = Queue::pluck('name', 'name');
    	return view('reports.hourly_service_level_graph', compact('queues'));
    }

    public function getHourlyServiceLevelGraphData(Request $request)
    {
    	$dt = new Carbon($request->date);
    	$queue = Queue::findOrFail($request->queue);
    	$service_level = $queue->servicelevel;

    	$totalCalls = QueueLog::where([
    		["event", "ENTERQUEUE"],
    		["queuename", $queue->name]
    	])->whereDate("created", $dt->format("Y-m-d"))->get()->groupBy(function ($data) {
    		return Carbon::parse($data->created)->format("H");
    	});

    	$totalAnsweredCalls = QueueLog::where([
    		["event", "CONNECT"],
    		["queuename", $queue->name],
    		["data1", "<", $service_level]
    	])->whereDate("created", $dt->format("Y-m-d"))->get()->groupBy(function ($data) {
    		return Carbon::parse($data->created)->format("H");
    	});

    	$processed = new Collection;

    	$hours = [];

    	for ($i=0; $i < 24; $i++) { 
    		$i = sprintf("%02d", $i);
    		$hours[$i] = 0;
    	}

    	foreach ($hours as $key => $value) {

    		$totalProcessedCalls = $totalCalls->get($key) == null ? 0 : $totalCalls->get($key)->count();
    		$totalAnsweredtotalProcessedCalls = $totalAnsweredCalls->get($key) == null ? 0 : $totalAnsweredCalls->get($key)->count();
    		$totalPercent = $totalProcessedCalls == 0 ? number_format(100, 2, '.', '') : number_format((float)((int)$totalAnsweredtotalProcessedCalls/(int)$totalProcessedCalls) * 100, 2, '.', '');

    		$processed->push([
				"hour" => $key,
				"total" => $totalProcessedCalls,
				"answered" => $totalAnsweredtotalProcessedCalls,
				"count" => $totalPercent
			]);
    		
    		$i++;
		}

    	return response()->json($processed, 200);
    }

    public function getAverageAnsweringSpeed()
    {
    	$queues  = Queue::pluck('name', 'name');
    	return view('reports.average_answer_speed', compact('queues'));
    }

    public function getAverageAnsweringSpeedData(Request $request)
    {
    	$dt = new Carbon($request->date);
    	$queue = Queue::findOrFail($request->queue);

    	$calls = QueueLog::where([
    		["event", "CONNECT"],
    		["queuename", $queue->name]
    	])->whereDate("created", $dt->format("Y-m-d"))->get()->groupBy('agent');

    	$processed = new Collection;
    	$count = 0;

    	$calls->each(function ($item, $key) use ($processed, $count) {
    		$item->map(function ($nItem, $nKey) use (&$count) {
				$count = $count + (int) $nItem->data3;
			});
    		$processed->push([
    			"agent" => $key,
    			"total_calls" => $item->count(),
    			"total_ringtime_duration" => $count,
    			"avg_ringtime_duration" => number_format($count/$item->count(), 2, '.', '')
    		]);
    	});

    	return DataTables::of($processed->all())->toJson();
    }

    public function getAverageAnsweringSpeedGraph()
    {
    	// $queues = Queue::pluck('name', 'name');
    	return view('reports.average_answer_speed_graph', compact('queues'));
    }

    public function getAverageAnsweringSpeedGraphData(Request $request)
    {
    	$dt = new Carbon($request->date);
    	$queue = Queue::findOrFail($request->queue);

    	$calls = QueueLog::where([
    		["event", "CONNECT"],
    		["queuename", $queue->name]
    	])->whereDate("created", $dt->format("Y-m-d"))->get()->groupBy('agent');

    	$processed = new Collection;
    	$count = 0;

    	$calls->each(function ($item, $key) use ($processed, $count) {
    		$item->map(function ($nItem, $nKey) use (&$count) {
				$count = $count + (int) $nItem->data3;
			});
    		$processed->push([
    			"agent" => $key,
    			"total_calls" => $item->count(),
    			"total_ringtime_duration" => $count,
    			"avg_ringtime_duration" => number_format($count/$item->count(), 2, '.', '')
    		]);
    	});

    	return response()->json($processed, 200);
    }

    public function getAgentAbandon()
    {
    	return view('reports.agent_abandon');
    }

    public function getAgentAbandonData(Request $request)
    {
    	$dt = new Carbon($request->date);
    	$queue = Queue::findOrFail($request->queue);

    	$calls = QueueLog::where([
    		["event", "RINGNOANSWER"],
    		["queuename", $queue->name]
    	])->whereDate("created", $dt->format("Y-m-d"))->get()->groupBy('agent');

    	$processed = new Collection;
    	$count = 0;

    	$calls->each(function ($item, $key) use ($processed, $count) {
    		$item->map(function ($nItem, $nKey) use (&$count) {
				$count = $count + (int) $nItem->data1;
			});
    		$processed->push([
    			"agent" => $key,
    			"total_calls" => $item->count(),
    			"total_ringtime_duration" => $count/1000,
    			"avg_ringtime_duration" => number_format(($count/1000)/$item->count(), 2, '.', '')
    		]);
    	});

    	return DataTables::of($processed->all())->toJson();	
    }

    public function getAgentAbandonGraph()
    {
    	// $queues = Queue::pluck('name', 'name');
    	return view('reports.agent_abandon_graph', compact('queues'));
    }

    public function getAgentAbandonGraphData(Request $request)
    {
    	$dt = new Carbon($request->date);
    	$queue = Queue::findOrFail($request->queue);

    	$calls = QueueLog::where([
    		["event", "RINGNOANSWER"],
    		["queuename", $queue->name]
    	])->whereDate("created", $dt->format("Y-m-d"))->get()->groupBy('agent');

    	$processed = new Collection;
    	$count = 0;

    	$calls->each(function ($item, $key) use ($processed, $count) {
    		$item->map(function ($nItem, $nKey) use (&$count) {
				$count = $count + (int) $nItem->data1;
			});
    		$processed->push([
    			"agent" => $key,
    			"total_calls" => $item->count(),
    			"total_ringtime_duration" => $count/1000,
    			"avg_ringtime_duration" => number_format(($count/1000)/$item->count(), 2, '.', '')
    		]);
    	});

    	return response()->json($processed, 200);
    }

    public function getHangup()
    {
    	return view('reports.hangup');
    }

    public function getHangupData(Request $request)
    {
    	$dt = new Carbon($request->date);
    	$queue = Queue::findOrFail($request->queue);

    	$calls = QueueLog::whereDate("created", $dt->format("Y-m-d"))
    		->where("queuename", $queue->name)
    		->where(function ($query) {
    			$query->where("event", "COMPLETEAGENT")
    				->orWhere("event", "COMPLETECALLER")
    				->orWhere("event", "ABANDON")
    				->orWhere("event", "RINGCANCELED");
    		})
    		->get()
    		->groupBy('event');

		//return dd($calls);

    	$processed = new Collection;
    	$count = 0;

    	$calls->each(function ($item, $key) use ($processed, $count) {
    		switch ($key) {
    			case 'COMPLETEAGENT':
    				$processed->push([
    					"event" => "Hangup by Agent",
    					"count" => $item->count(),
    					"description" => "Calls hung up by agent"
    				]);
    				break;
    			case 'COMPLETECALLER':
    				$processed->push([
    					"event" => "Hangup by Customer",
    					"count" => $item->count(),
    					"description" => "Calls hung up by customer"
    				]);
    				break;	
				case 'ABANDON':
    				$processed->push([
    					"event" => "Abandon Calls",
    					"count" => $item->count(),
    					"description" => "Calls abandon by customer"
    				]);
    				break;
				case 'RINGCANCELED':
    				$processed->push([
    					"event" => "Ring Canceled",
    					"count" => $item->count(),
    					"description" => "Call canceled by customer while ringing"
    				]);
    				break;
    			default:
    				break;
    		}
    	});

    	return DataTables::of($processed->all())->toJson();	
    }

    public function getHangupGraph()
    {
    	return view('reports.hangup_graph');
    }

    public function getHangupGraphData(Request $request)
    {
    	$dt = new Carbon($request->date);
    	$queue = Queue::findOrFail($request->queue);

    	$calls = QueueLog::whereDate("created", $dt->format("Y-m-d"))
    		->where("queuename", $queue->name)
    		->where(function ($query) {
    			$query->where("event", "COMPLETEAGENT")
    				->orWhere("event", "COMPLETECALLER")
    				->orWhere("event", "ABANDON")
    				->orWhere("event", "RINGCANCELED");
    		})->get()->groupBy('event');

    	$processed = new Collection;
    	$count = 0;

    	$calls->each(function ($item, $key) use ($processed, $count) {
    		switch ($key) {
    			case 'COMPLETEAGENT':
    				$processed->push([
    					"event" => "Hangup by Agent",
    					"count" => $item->count(),
    					"description" => "Calls hung up by agent"
    				]);
    				break;
    			case 'COMPLETECALLER':
    				$processed->push([
    					"event" => "Hangup by Customer",
    					"count" => $item->count(),
    					"description" => "Calls hung up by customer"
    				]);
    				break;	
				case 'ABANDON':
    				$processed->push([
    					"event" => "Abandon Calls",
    					"count" => $item->count(),
    					"description" => "Calls abandon by customer"
    				]);
    				break;
				case 'RINGCANCELED':
    				$processed->push([
    					"event" => "Ring Canceled",
    					"count" => $item->count(),
    					"description" => "Call canceled by customer while ringing"
    				]);
    				break;
    			default:
    				break;
    		}
    	});

    	return response()->json($processed, 200);
    }

    public function getHourlyCallsAnalysis()
    {
    	return view("reports.hourly_calls_analysis");
    }

    public function getHourlyCallsAnalysisData(Request $request)
    {
    	$dt = new Carbon($request->date);
    	$queue = Queue::findOrFail($request->queue);
    	$agents = Role::where("name", "Agent")->first()->users;
    	$blends = Role::where("name", "Blended")->first()->users;
    	$tech = "PJSIP";

    	$agents = $agents->concat($blends);

    	$agents = $agents->map(function ($agent) {
    		return $agent->only(["name"]);
    	});

    	$service_level = $queue->servicelevel;

    	$totalCalls = QueueLog::whereDate("created", $dt->format("Y-m-d"))->where([
    		["event", "ENTERQUEUE"],
    		["queuename", $queue->name]
    	])->get()->groupBy(function ($data) {
    		return Carbon::parse($data->created)->format("H");
    	});

    	$totalAnsweredCalls = QueueLog::whereDate("created", $dt->format("Y-m-d"))->where([
    		["event", "CONNECT"],
    		["queuename", $queue->name]
    	])->get()->groupBy(function ($data) {
    		return Carbon::parse($data->created)->format("H");
    	});

    	$totalAnsweredBFT = QueueLog::where([
    		["event", "CONNECT"],
    		["queuename", $queue->name],
    		["data1", "<=", $service_level]
    	])->whereDate("created", $dt->format("Y-m-d"))->get()->groupBy(function ($data) {
    		return Carbon::parse($data->created)->format("H");
    	});

    	$connectedCalls = QueueLog::where("queuename", $queue->name)
    	->whereIn("event", ["COMPLETEAGENT", "COMPLETECALLER"])
    	->whereDate("created", $dt->format("Y-m-d"))->get()->groupBy(function ($data) {
    		return Carbon::parse($data->created)->format("H");
    	});

    	$totalAbandonCalls = QueueLog::whereDate("created", $dt->format("Y-m-d"))->where([
    		["event", "ABANDON"],
    		["queuename", $queue->name]
    	])->get()->groupBy(function ($data) {
    		return Carbon::parse($data->created)->format("H");
    	});

    	$totalAbandonAFT = QueueLog::whereDate("created", $dt->format("Y-m-d"))->where([
    		["event", "ABANDON"],
    		["queuename", $queue->name],
    		["data3", ">", $service_level]
    	])->get()->groupBy(function ($data) {
    		return Carbon::parse($data->created)->format("H");
    	});

    	$holdTime = QueueLog::whereDate("created", $dt->format("Y-m-d"))->where("queuename", $queue->name)
    	->whereIn("event", ["HOLD", "UNHOLD"])
    	->orderBy("created")->get()->groupBy("callid");

    	$acwTime = QueueLog::whereDate("created", $dt->format("Y-m-d"))->where("queuename", $queue->name)
    	->whereIn("data1", ["Wrapup-Start", "Wrapup-End"])
    	->orderBy("created")->get()->groupBy(function ($data) {
    		return Carbon::parse($data->created)->format("H");
    	});

    	$loginAgents = QueueLog::whereDate("created", $dt->format("Y-m-d"))
    	->where("event", "CONNECT")
    	->select("agent", "created")
    	->get()
    	->groupBy(function ($data) {
    		return Carbon::parse($data->created)->format("H");
    	});

    	$tProcess = new Collection;
    	$wProcess = new Collection;

    	foreach ($acwTime as $key => $value) {
			$time = 0;
			$uniqueid = $key;
			foreach ($value as $nKey => $nValue) {

				if($nValue->event == "Wrapup-End") {
					// Calculate differenc
					$prev = $value[$nKey - 1];
					$date1 = Carbon::parse($nValue->created);
					$date2 = Carbon::parse($prev->created);
					$time = $date2->diffInSeconds($date1);
				} elseif ($nValue->event == "Wrapup-Start" && $nKey == $value->count() - 1) {
					$record = Carbon::createFromFormat('Y-m-d H:i:s', "$request->date $key:59:59");
					$date1 = Carbon::parse($nValue->created);
					$date2 = Carbon::parse($record);
					$time = $date2->diffInSeconds($date1);
					// return dd($nValue->event == "HOLD" && $nKey == $value->count());
				}
			}

			$wProcess->put($key, [
				"totalAcwTime" => $time
			]);
		}

    	foreach ($holdTime as $key => $value) {
			$time = 0;
			$uniqueid = $key;
			foreach ($value as $nKey => $nValue) {

				if($nValue->event == "UNHOLD") {
					// Calculate differenc
					$prev = $value[$nKey - 1];
					$date1 = Carbon::parse($nValue->created);
					$date2 = Carbon::parse($prev->created);
					$time = $date2->diffInSeconds($date1);
				} elseif ($nValue->event == "HOLD" && $nKey == $value->count() - 1) {
					$record = Cdr::where("uniqueid", $nValue->callid)->first();
					$date1 = Carbon::parse($nValue->created);
					$date2 = Carbon::parse($record->end);
					$time = $date2->diffInSeconds($date1);
					// return dd($nValue->event == "HOLD" && $nKey == $value->count());
				}
			}

			$tProcess->push([
				"uniqueid" => $uniqueid,
				"totalHoldTime" => $time,
				"calltime" => Carbon::createFromTimestamp((float)$uniqueid)
			]);
		}
    	
    	$tProcess = $tProcess->groupBy(function ($data) {
    		return $data["calltime"]->format("H");
    	});

    	$hours = [];

    	for ($i=0; $i < 24; $i++) { 
    		$i = sprintf("%02d", $i);
    		$hours[$i] = 0;
    	}

    	$processed = new Collection;
    	$tProcess = new Collection;
    	$talkTime = 0;
    	$totalTalkTime = 0;
    	$totalHoldTime = 0;
    	$agents = 0;

    	foreach ($hours as $key => $value) {

    		$totalProcessedCalls = $totalCalls->get($key) == null ? 0 : $totalCalls->get($key)->count();
    		$totalAnsweredtotalProcessedCalls = $totalAnsweredCalls->get($key) == null ? 0 : $totalAnsweredCalls->get($key)->count();
    		

    		$totalProcessedBFTCalls = $totalAnsweredBFT->get($key) == null ? 0 : $totalAnsweredBFT->get($key)->count();

    		$totalPercent = $totalProcessedCalls == 0 ? number_format(100, 2, '.', '') : number_format((float)((int)$totalProcessedBFTCalls/(int)$totalProcessedCalls) * 100, 2, '.', '');

    		$totalAFT = $totalAnsweredtotalProcessedCalls - $totalProcessedBFTCalls;
	    	
	    	$totalHoldTime = $tProcess->get($key) == null ? 0 : $tProcess->get($key)->sum("totalHoldTime");

	    	$totalTalkTime = $connectedCalls->get($key) == null ? 0 : $connectedCalls->get($key)->sum->data2 - $totalHoldTime;

	    	$avgTalkTime = $totalAnsweredtotalProcessedCalls == 0 ? 0 : $totalTalkTime/$totalAnsweredtotalProcessedCalls;

	    	$totalAnsSpeed = $totalAnsweredCalls->get($key) == null ? 0 : $totalAnsweredCalls->get($key)->sum->data1;
	    	$avgAnsSpeed = $totalAnsweredtotalProcessedCalls == 0 ? 0 : $totalAnsSpeed/$totalAnsweredtotalProcessedCalls;

	    	$agents = $loginAgents->get($key) == null ? 0 : $loginAgents->get($key)->unique("agent")->count();

	    	$totalAbandonCallsProcessed = $totalAbandonCalls->get($key) == null ? 0 : $totalAbandonCalls->get($key)->count();

	    	$totalAbandonAFTProcessed = $totalAbandonAFT->get($key) == null ? 0 : $totalAbandonAFT->get($key)->count();

	    	$totalAbandonBFTProcessed = $totalAbandonCallsProcessed - $totalAbandonAFTProcessed;

	    	$workingHours = 3600;

	    	$totalHandleTime = $wProcess->get($key) == null ? 0 : $wProcess->get($key)["totalAcwTime"];

	    	$totalProcessHandleTime = $totalTalkTime + $totalHandleTime;

    		$processed->push([
    			"date" => $request->date,
				"hour" => $key,
				"servicelevel" => $totalPercent,
				"availableAgents" => $agents,
				"totalCalls" => $totalProcessedCalls,
				"callsPerAgent" => $agents == 0 ? 0 : round($totalProcessedCalls/$agents),
				"answered" => $totalAnsweredtotalProcessedCalls,
				"answeredCallsPerAgent" => $agents == 0 ? 0 : round($totalAnsweredtotalProcessedCalls/$agents),
				"BFT" => $totalProcessedBFTCalls,
				"AFT" => $totalAFT,
				"avgTalkTime" => number_format($avgTalkTime, 2, ".", null),
				"talkTimePerHour" => $avgTalkTime == 0 ? 0 : $totalTalkTime,
				"avgAnsSpeed" => number_format($avgAnsSpeed, 2, ".", null),
				"abandonCalls" => $totalAbandonCallsProcessed,
				"abandonAFT" => $totalAbandonAFTProcessed,
				"abandonBFT" => $totalAbandonBFTProcessed,
				"agentUtilization" => number_format($totalProcessHandleTime/$workingHours * 100, 2, ".", null)
			]);
		}

		return DataTables::of($processed->all())->toJson();
		// return dd($processed);
		
    }

    public function getCallCenterPerformance()
    {
    	return view("reports.agent_performance");
    }

    public function getCallCenterPerformanceData(Request $request)
    {
    	$dt = Carbon::parse($request->date);
    	$queue = Queue::findOrFail($request->queue);
    	$roles = Role::with('users')->whereIn("name", ["Agent", "Blended", "Outbound"])->get();
    	$agents = $roles->flatMap(function ($values) {
    		return $values->users;
    	});
    	
    	$callsLanded = QueueLog::whereDate("created", $dt->format("Y-m-d"))->where("queuename", $queue->name)
    	->whereIn("event", ["CONNECT", "RINGCANCELED", "RINGNOANSWER"])
    	->whereIn("agent", $agents->pluck("name"))
    	->get()
    	->groupBy("agent");

    	$obCalls = Cdr::whereDate("start", $dt->format("Y-m-d"))->whereIn("src", $agents->pluck("extension"))->get()->groupBy(function ($item, $key) {
    		return User::getByExtension($item->src)->name;
    	});

    	$completedCalls = QueueLog::whereDate("created", $dt->format("Y-m-d"))->where("queuename", $queue->name)
    	->whereIn("event", ["COMPLETECALLER", "COMPLETEAGENT"])
    	->whereIn("agent", $agents->pluck("name"))
    	->get()
    	->groupBy("agent");

    	$holdCalls = QueueLog::whereDate("created", $dt->format("Y-m-d"))->where("queuename", $queue->name)
    	->whereIn("event", ["HOLD", "UNHOLD"])
    	->whereIn("agent", $agents->pluck("name"))
    	->orderBy("created")
    	->get()
    	->groupBy("callid");

    	$acwTime = QueueLog::whereDate("created", $dt->format("Y-m-d"))->where("queuename", $queue->name)
    	->whereIn("data1", ["Wrapup-Start", "Wrapup-End"])
    	->whereIn("event", ["PAUSE", "UNPAUSE"])
    	->whereIn("agent", $agents->pluck("name"))
    	->orderBy("created")
    	->get()
    	->groupBy("agent");

    	$loginTime = QueueLog::whereDate("created", $dt->format("Y-m-d"))->where("queuename", $queue->name)
    	->whereIn("event", ["ADDMEMBER", "REMOVEMEMBER"])
    	->whereIn("agent", $agents->pluck("name"))
    	->orderBy("created")
    	->get()
    	->groupBy("agent");

    	$readyTime = QueueLog::whereDate("created", $dt->format("Y-m-d"))->where("queuename", $queue->name)
    	->whereIn("event", ["PAUSE", "UNPAUSE"])
    	->whereNotIn("data1", ["Wrapup-Start", "Wrapup-End"])
    	->whereIn("agent", $agents->pluck("name"))
    	->orderBy("created")
    	->get()
    	->groupBy("agent");

    	$connectedCalls = new Collection;
    	$ringNoAnswer = new Collection;
    	$ringCanceled = new Collection;
    	$processed = new Collection;
    	$acwProcess = new Collection;
    	$holdProcess = new Collection;
    	$LoginProcess = new Collection;
    	$pauseProcess = new Collection;

    	foreach ($readyTime as $key => $value) {
    		$diffInSeconds = 0;
    		foreach ($value as $_key => $_value) {
    			$next = $_key + 1;
    			if ($next < $value->count() && $_value->event == "PAUSE" && $value[$next]->event == "UNPAUSE") {
    				$date1 = Carbon::parse($_value->created);
    				$date2 = Carbon::parse($value[$next]->created);
    				$diffInSeconds = $diffInSeconds + $date2->diffInSeconds($date1);
    			} elseif ($next == $value->count() && $_value->event == "PAUSE") {
    				// Get end of day time
    				$date1 = Carbon::parse($_value->created);
    				$date2 = Carbon::parse($date1->toDateString() . " 23:59:59");
    				$diffInSeconds = $diffInSeconds + $date2->diffInSeconds($date1);
    			}
    		}
    		$pauseProcess->put($key, [
    			"pauseTime" => $diffInSeconds
    		]);
    	}

    	foreach ($loginTime as $key => $value) {
    		$diffInSeconds = 0;
    		foreach ($value as $_key => $_value) {
    			$next = $_key + 1;
    			$agent = $_value->agent;
    			if ($next < $value->count() && $_value->event == "ADDMEMBER" && $value[$next]->event == "REMOVEMEMBER") {
    				$date1 = Carbon::parse($_value->created);
    				$date2 = Carbon::parse($value[$next]->created);
    				$diffInSeconds = $diffInSeconds + $date2->diffInSeconds($date1);
    			} elseif ($next == $value->count() && $_value->event == "ADDMEMBER") {
    				// Get end of day time
    				$date1 = Carbon::parse($_value->created);
    				$date2 = Carbon::parse($date1->toDateString() . " 23:59:59");
    				$diffInSeconds = $diffInSeconds + $date2->diffInSeconds($date1);
    			}
    		}
    		$LoginProcess->put($key, [
    			"loginTime" => $diffInSeconds
    		]);
    	}

    	foreach ($holdCalls as $key => $value) {
    		$diffInSeconds = 0;
    		$records = 0;
    		foreach ($value as $nKey => $nValue) {
    			$next = $nKey + 1;
    			$agent = $nValue->agent;
    			if($next < $value->count()) {
    				if($nValue->event == "HOLD" && $value[$next]->event == "UNHOLD") {
    					$date1 = Carbon::parse($nValue->created);
	    				$date2 = Carbon::parse($value[$next]->created);
	    				$diffInSeconds = $diffInSeconds + $date2->diffInSeconds($date1);
    				}
    			} elseif ($next == $value->count()) {
    				if($nValue->event == "HOLD") {
    					$record = $completedCalls->get($nValue->agent)->groupBy(function ($data) {
				    		return $data->callid;
				    	})->get($nValue->callid)->first();
				    	$date1 = Carbon::parse($nValue->created);
	    				$date2 = Carbon::parse($record->created);
	    				$diffInSeconds = $diffInSeconds + $date2->diffInSeconds($date1);
    				}
    			}
    		}
    		$holdProcess->put($key, [
    			"sum" => $diffInSeconds,
    			"agent" => $agent
    		]);
    	}

    	foreach ($acwTime as $key => $value) {
    		$diffInSeconds = 0;
    		$records = 0;
    		foreach ($value as $nKey => $nValue) {
    			$next = $nKey + 1;
    			// return dd($value[$next]->data1);
    			if($next < $value->count()) {
    				if($nValue->data1 == "Wrapup-Start" && $value[$next]->data1 == "Wrapup-End") {
	    				$date1 = Carbon::parse($nValue->created);
	    				$date2 = Carbon::parse($value[$next]->created);
	    				$diffInSeconds = $diffInSeconds + $date2->diffInSeconds($date1);
	    				$records++;
	    			} 
    			}
    		}
    		$acwProcess->put($key, [
    			"sum" => $diffInSeconds,
    			"avg" => $records == 0 ? 0 : round($diffInSeconds/$records, 2, null)
    		]);
    	}

    	// foreach ($callsLanded as $nkey => $nvalue) {
    	// 	$connectedCalls->put($nkey, $nvalue->filter(function ($value, $key) {
	    // 		return $value->event == "CONNECT";
	    // 	}));

	    // 	$ringNoAnswer->put($nkey, $nvalue->filter(function ($value, $key) {
	    // 		return $value->event == "RINGNOANSWER";
	    // 	}));

	    // 	$ringCanceled->put($nkey, $nvalue->filter(function ($value, $key) {
	    // 		return $value->event == "RINGCANCELED";
	    // 	}));

	    // 	$processed->push([
	    // 		"name" => $nkey,
	    // 		"recieved" => $nvalue->count(),
	    // 		"answered" => $connectedCalls->get($nkey)->count(),
	    // 		"notanswer" => $ringNoAnswer->get($nkey)->count() + $ringCanceled->get($nkey)->count(),
	    // 		"outcalls" => $outcalls->get($nkey)->count(),
	    // 		"avgAnsDelay" => round($connectedCalls->get($nkey)->avg->data3, 2, null),
	    // 		"talktimeTotal" => gmdate("H:i:s", $completedCalls->get($nkey)->sum->data2),
	    // 		"talkTimeAvg" => round($completedCalls->get($nkey)->avg->data2, 2, null),
	    // 		"outTalkTimeTotal" => gmdate("H:i:s", $outcalls->get($nkey)->sum->billsec),
	    // 		"outAvg" => round($outcalls->get($nkey)->avg->billsec, 2, null),
	    // 		"acwTime" => gmdate("H:i:s", $acwProcess->get($nkey)["sum"]),
	    // 		"avgAcwTime" => $acwProcess->get($nkey)["avg"],
	    // 		"holdTime" => $holdProcess->groupBy("agent")->get($nkey)->sum("sum"),
	    // 		"avgHoldTime" => round($holdProcess->groupBy("agent")->get($nkey)->sum("sum")/$connectedCalls->get($nkey)->count(), 2, null),
	    // 		"obIdle" => 0
	    // 	]);
    	// }

    	foreach ($agents->pluck("id", "name")->toArray() as $key => $value) {

    		$name = $key;
    		$recieved = 0;
    		$answered = 0;
    		$notanswer = 0;
    		$outcalls = 0;
    		$avgAnsDelay = 0;
    		$talktimeTotal = 0;
    		$outTalkTimeTotal = 0;
    		$talkTimeAvg = 0;
    		$outAvg = 0;
    		$acwTime = 0;
    		$avgAcwTime = 0;
    		$holdTime = 0;
    		$avgHoldTime = 0;
    		$obIdle = 0;
    		$ibIdle = 0;
    		$notRdy = 0;
    		$mann = 0;

    		$agentCalls = $callsLanded == null ? null : $callsLanded->get($key);

    		if($agentCalls !== null) {

    			$recieved = $agentCalls->count();
    			$answered = $agentCalls->filter(function ($item, $key) {
    				return $item->event == "CONNECT";
    			})->count();
    			$notanswer = $agentCalls->filter(function ($item, $key) {
    				return $item->event == "RINGNOANSWER" || $item->event == "RINGCANCELED";
    			})->count();

    			$avgAnsDelay = $agentCalls->filter(function ($item, $key) {
    				return $item->event == "CONNECT";
    			})->avg->data3;

    			$talktimeTotal = $completedCalls->get($key)->sum->data2;
    			$talkTimeAvg = $completedCalls->get($key)->avg->data2;

    			$acwTime = $acwProcess->get($key)["sum"];
    			$avgAcwTime = $acwProcess->get($key)["avg"];

    			$holdTime = $holdProcess->count() == 0 ? 0 : $holdProcess->groupBy("agent")->get($key)->sum("sum");
    			$avgHoldTime = $holdTime/$answered;

    			$loginTime = $LoginProcess->get($key)["loginTime"];
    			$notRdy = $pauseProcess->get($key)["pauseTime"];

    			$ibIdle = $loginTime - $notRdy - $acwTime - $talktimeTotal;
    			$mann = $loginTime;
    		}

    		$out = $obCalls == null ? null : $obCalls->get($key);

			if($out !== null) {
				$outcalls = $out->count();
				$outTalkTimeTotal = $obCalls->get($key)->sum->billsec;
				$outAvg = $obCalls->get($key)->avg->billsec;
			}

    		$processed->push([
    			"name" => $name,
	    		"recieved" => $recieved,
	    		"answered" => $answered,
	    		"notanswer" => $notanswer,
	    		"outcalls" => $outcalls,
	    		"avgAnsDelay" => round($avgAnsDelay, 2, null),
	    		"talktimeTotal" => gmdate("H:i:s", $talktimeTotal),
	    		"talkTimeAvg" => round($talkTimeAvg, 2, null),
	    		"outTalkTimeTotal" => gmdate("H:i:s", $outTalkTimeTotal),
	    		"outAvg" => round($outAvg, 2, null),
	    		"acwTime" => gmdate("H:i:s", $acwTime),
	    		"avgAcwTime" => round($avgAcwTime, 2, null),
	    		"holdTime" => gmdate("H:i:s", $holdTime),
	    		"avgHoldTime" => round($avgHoldTime, 2, NULL),
	    		"obIdle" => gmdate("H:i:s", $obIdle),
	    		"ibIdle" => gmdate("H:i:s", $ibIdle),
	    		"notRdy" => gmdate("H:i:s", $notRdy),
	    		"mann" => gmdate("H:i:s", $mann)
    		]);
    	}

    	// return dd($LoginProcess);
    	return DataTables::of($processed)->toJson();
    }

    public function getWorkcodeAnalysis()
    {
    	return view("reports.workcode_analysis");
    }

    public function getWorkcodeAnalysisData(Request $request)
    {
    	$dt = Carbon::parse($request->date);
    	$queue = Queue::findOrFail($request->queue);

    	$workcodes = Workcode::pluck("name", "id");

		$totalCalls = QueueLog::whereDate("created", $dt->format("Y-m-d"))
		->where([
			["queuename", $queue->name],
			["event", "WORKCODE"]
		])
		->distinct()
		->pluck("callid");

		$processed = new Collection;

		foreach ($workcodes as $key => $value) {
			$workcode = $key;
			$name = $value;
			$talkTime = 0;
			$max = 0;
			$min = 0;
			$avg = 0;
			$total = 0;
			$percent = 0;

			$query = QueueLog::whereDate("created", $dt->format("Y-m-d"))
			->where([
				["queuename", $queue->name],
				["event", "WORKCODE"],
				["data1", $value]
			])
			->distinct()
			->pluck("callid");

			$cdrs = Cdr::whereIn("uniqueid", $query)->get();

			if($cdrs->count() > 0) {
				$talkTime = $cdrs->sum->billsec;
				$max = $cdrs->max->billsec;
				$min = $cdrs->min->billsec;
				$avg = $cdrs->avg->billsec;
				$total = $cdrs->count();
				$percent = ($total/$totalCalls->count()) * 100;
			}

			$processed->push([
				"id" => $workcode,
				"name" => $name,
				"talkTime" => gmdate("H:i:s", $talkTime),
				"max" => $max,
				"min" => $min,
				"avg" => round($avg, 2, null),
				"total" => $total,
				"percent" => round($percent, 2, null)
			]);

		}

		return DataTables::of($processed)->toJson();
    }
}
