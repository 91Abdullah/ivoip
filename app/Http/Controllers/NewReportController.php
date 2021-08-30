<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewReportController extends Controller
{
    public function getAgentKPIReportView(Request $request)
    {
        return view('newReports.agentKPI');
    }

    public function getAgentKPIReportData(Request $request)
    {
        $request->validate([
            'date' => ['required', 'date_format:Y-m-d']
        ]);
        [$year, $month, $day] = explode("-", $request->date);
        $query1 = DB::table('queue_log')->selectRaw("ROUND(AVG(data2),2) as 'avg_talk_time', count(*) as 'total_calls_answered', SUM(IF(event = 'COMPLETECALLER', 1, 0))/count(*) as 'calls_abandoned', SUM(IF(event = 'COMPLETEAGENT', 1, 0))/count(*) as 'calls_drop', agent")->whereIn("event", ["COMPLETECALLER", "COMPLETEAGENT"])->whereYear("created", $year)->whereMonth("created", $month)->whereDay('created', $day)->groupBy(['agent'])->get();
        $query2 = DB::table('queue_log')->selectRaw("ROUND(AVG(data1),2) as 'avg_hold_time', ROUND(AVG(data3), 2) as 'avg_ans_speed', agent")->where("event", "CONNECT")->whereYear('created', $year)->whereMonth('created', $month)->whereDay('created', $day)->groupBy(['agent'])->get();
        $query3 = DB::table('queue_log')->selectRaw("ROUND(AVG(data1)/1000,2) as 'avg_ring_time', count(*) as 'total_calls_drop', agent")->where('event', "RINGNOANSWER")->whereYear('created', $year)->whereMonth('created', $month)->whereDay('created', $day)->groupBy(['agent'])->get();
        $query4 = DB::select("SELECT A.agent, ROUND(AVG(TIMESTAMPDIFF(SECOND, A.created, B.created)), 2) as 'avg_call_time' FROM `queue_log` as A join `queue_log` as B on A.callid = B.callid WHERE A.event = 'CONNECT' and B.event = 'WORKCODE' and year(A.`created`) = ${year} and month(A.`created`) = ${month} and day(A.`created`) = ${day} group by A.agent");
        $query5 = DB::select("SELECT A.agent, TIMEDIFF(B.created, A.created) as 'time_in_queue' FROM `queue_log` as A join `queue_log` as B on A.agent = B.agent where year(A.`created`) = ${year} and month(A.`created`) = ${month} and day(A.`created`) = ${day} and year(B.`created`) = ${year} and month(B.`created`) = ${month} and day(B.`created`) = ${day} and A.event = 'ADDMEMBER' and B.event = 'REMOVEMEMBER' group by A.agent");
        $query1->transform(function ($i) {
            return (array)$i;
        });
        $query2->transform(function ($i) {
            return (array)$i;
        });
        $query3->transform(function ($i) {
            return (array)$i;
        });
        $query1Array = $query1->keyBy('agent')->toArray();
        $query2Array = $query2->keyBy('agent')->toArray();
        $query3Array = $query3->keyBy('agent')->toArray();
        $array = collect($query5)->keyBy('agent');
        $array->transform(function ($i) {
            return (array)$i;
        });
        $finalArray = $array->toArray();
        $merged = array_merge_recursive($query1Array, $query2Array, $query3Array, collect($query4)->keyBy('agent')->toArray(), $finalArray);
        //return dd($query5);
        return view('newReports.agentKPI', ['data' => $merged, 'query' => $request->date]);
    }
}
