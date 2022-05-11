<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Cdr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Html\Builder; // import class on controller
use Yajra\DataTables\Facades\DataTables;
use App\User;

class RecordingsController extends Controller
{
    /**
     * @throws Exception
     */
    public function getRecordings(Request $request)
    {
    	$path = "/var/spool/asterisk/monitor/";
    	$dt = Carbon::parse($request->date);

    	$calls = Cdr::whereDate("start", $dt->format("Y-m-d"))
    	->where("disposition", "ANSWERED")
    	->distinct()
    	->get();

    	$process = new Collection;

    	foreach ($calls as $key => $value) {
            $agent = "N/A";
            $name = "N/A";
            if(!str_contains($value->dstchannel, "TCL") && str_contains($value->dstchannel, "PJSIP")) {
                $agent = explode("-", explode("/", $value->dstchannel)[1])[0];
                $name = User::getByExtension($agent)->name;
            }
            $process->push([
    			"id" => $value->id,
    			"source" => $value->src,
    			"destination" => $value->dst,
    			"start" => $value->start,
			    "agent" => $agent,
    			"name" => $name,
    			"end" => $value->end,
    			"duration" => $value->billsec,
    			"uniqueid" => $value->uniqueid,
			    "play" => $value->recordingfile,
    			"link" => $value->recordingfile
    		]);
    	}

    	return DataTables::of($process)->toJson();

    }

    public function downloadFile($path)
    {
    	$spath = "/var/spool/asterisk/monitor/";
        $date = explode("-", $path);
        $date = Carbon::parse($date[3]);
        $folderPath = "/{$date->format('Y')}/{$date->format('m')}/{$date->format('d')}/$path";
    	return Storage::disk('recording')->download($folderPath);
    }
}
