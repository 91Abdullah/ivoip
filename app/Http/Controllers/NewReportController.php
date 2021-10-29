<?php

namespace App\Http\Controllers;

use App\QueueLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewReportController extends Controller
{
    public function getAgentKPIReportView(Request $request)
    {
        return view('newReports.agentKPI');
    }

    public function getAgentKPIReportViewNew(Request $request)
    {
        return view('newReports.agentKPI2');
    }

    public function getAgentKPIReportDataNew(Request $request)
    {
        $request->validate([
            'date' => ['required', 'date_format:Y-m-d']
        ]);
        $date = $request->date;
        $query1 = DB::select("SELECT a.agent, a.created as login_time, b.created as logout_time, TIMESTAMPDIFF(MINUTE, a.created, b.created) as total_time, 480 as total_required_time FROM `queue_log` as a join `queue_log` as b on a.agent = b.agent where a.event = 'ADDMEMBER' and b.event = 'REMOVEMEMBER' and date(a.`created`) = ? and date(b.created) = ? group by agent", [$date, $date]);
        $query2 = DB::select("SELECT a.agent, ROUND(TIMESTAMPDIFF(SECOND, a.created, b.created)/60, 2) as total_break, 40 as total_allowed_break FROM `queue_log` as a join queue_log as b on a.agent = b.agent and a.data1 = b.data1 where a.event = 'PAUSE' and b.event = 'UNPAUSE' and a.data1 NOT IN ('Wrapup-Start', 'Outbound-Start') and b.data1 NOT IN ('Wrapup-End', 'Outbound-End') and date(a.created) = ? and date(b.created) = ? group by agent", [$date, $date]);
        $query3 = DB::select("SELECT agent, ROUND(SUM(data2)/60, 2) as total_talk_time, ROUND(AVG(data2)/60, 2) as avg_talk_time from queue_log where event in ('COMPLETEAGENT', 'COMPLETECALLER') and date(created) = ? group by agent", [$date]);
        $query4 = DB::select("SELECT a.agent, ROUND(SUM(TIMESTAMPDIFF(SECOND, a.created, b.created))/60, 2) as acw_time, ROUND(AVG(TIMESTAMPDIFF(SECOND, a.created, b.created))/60, 2) as avg_acw_time from queue_log a join queue_log b on a.callid = b.callid and a.agent = b.agent and a.event in ('COMPLETEAGENT', 'COMPLETECALLER') and b.event = 'WORKCODE' where date(a.created) = ? and date(b.created) = ? group by a.agent", [$date, $date]);
        $query1 = collect($query1)->keyBy('agent');
        $query2 = collect($query2)->keyBy('agent');
        $query3 = collect($query3)->keyBy('agent');
        $query4 = collect($query4)->keyBy('agent');
        $query1->transform(function ($value) {
            return (array)$value;
        });
        $query2->transform(function ($value) {
            return (array)$value;
        });
        $query3->transform(function ($value) {
            return (array)$value;
        });
        $query4->transform(function ($value) {
            return (array)$value;
        });
        $merged = array_merge_recursive($query1->toArray(), $query2->toArray(), $query3->toArray(), $query4->toArray());
        return view('newReports.agentKPI2', ['data' => $merged, 'query' => $request->date]);
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

    public function getHourlyAnalysisOfAgent(Request $request)
    {
        if(!$request->has('hour') && !$request->has('date')) {
            $query = QueueLog::query()->select(['users.extension as agent_id', 'agent as agent', DB::raw('COUNT(event) as calls_taken'), DB::raw('date(created) as date'), DB::raw('HOUR(created) as hour')])->where('event', 'CONNECT')->whereDate('created', $request->date)->whereRaw("HOUR(created) = {$request->hour}")->groupBy(['agent'])->join('users', 'users.name', '=', 'agent')->get()->toArray();
            return view('newReports.hourlyAnalysisOfAgent', ['data' => $query]);
        } else {
            redirect()->back()->withErrors("Invalid parameters entered.");
        }
    }
}
