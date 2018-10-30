<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Cdr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder; // import class on controller

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
    		$process->push([
    			"id" => $value->id,
    			"source" => $value->src,
    			"destination" => $value->dst,
    			"start" => $value->start,
    			"end" => $value->end,
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

    public function agentPlay($file)
    {
        return Storage::disk('recording')->download($file);
    }
}
