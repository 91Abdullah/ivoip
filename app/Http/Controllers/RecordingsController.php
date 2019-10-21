<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Cdr;
use Illuminate\Support\Collection;
use Yajra\DataTables\Html\Builder; // import class on controller
use DataTables;
use Storage;

class RecordingsController extends Controller
{
    public function getRecordings(Request $request)
    {
    	$path = "/var/spool/asterisk/monitor/";
    	$dt = Carbon::parse($request->date);

    	$calls = Cdr::whereDate("start", $dt->format("Y-m-d"))
    	->where("disposition", "ANSWERED")
    	->distinct()
    	->get();

    	// return dd($calls);

    	$process = new Collection;

    	foreach ($calls as $key => $value) {
    	    $agent = "N/A";
    	    $name = "N/A";

    	    if(str_contains($value->dstchannel, "PJSIP")) {
    	        $agent = explode("-", explode("/", $value->dstchannel)[1])[0];
    	        $name = User::getByExtension($agent)->name;
            } elseif(str_contains($value->channel, "PJSIP")) {
                $agent = explode("-", explode("/", $value->channel)[1])[0];
                $name = User::getByExtension($agent)->name;
            }

    		$process->push([
    			"id" => $value->id,
    			"source" => $value->src,
    			"destination" => $value->dst == "100" ? "Queue - " . $value->dst : $value->dst,
    			"start" => $value->start,
    			"end" => $value->end,
    			"agent" => $agent,
    			"name" => $name,
    			"duration" => $value->billsec,
    			"uniqueid" => $value->uniqueid,
                "play" => $value->uniqueid . ".wav",
                "link" => $value->uniqueid . ".wav"
    		]);
    	}

    	return DataTables::of($process)->toJson();

    }

    public function downloadFile($path)
    {
    	$spath = "/var/spool/asterisk/monitor/";
    	return Storage::disk('recording')->download($path);
    }
    
    public function playFile($file)
    {
        return Storage::disk('recording')->url($file);
    }
}
