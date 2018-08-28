<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder; // import class on controller
use DataTables;
use App\User;
use App\QueueLog;
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function index(Request $request, Builder $htmlBuilder)
    {
    	return view('reports.index');
    }

    public function trunkUtilization()
    {
    	if($request->ajax()) {
    		return DataTables::of(User::select(['id', 'name', 'email', 'extension', 'created_at', 'updated_at']))->make(true);
    	}

    	$html = $htmlBuilder
        ->addColumn(['data' => 'id', 'name' => 'id', 'title' => 'Id'])
        ->addColumn(['data' => 'name', 'name' => 'name', 'title' => 'Name'])
        ->addColumn(['data' => 'email', 'name' => 'email', 'title' => 'Email'])
        ->addColumn(['data' => 'extension', 'name' => 'extension', 'title' => 'Extension'])
        ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created At'])
        ->addColumn(['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Updated At']);

        return view('reports.test', compact('html'));
    }

    public function agentAbandon()
    {

    }

    public function hangupByAgent()
    {

    }

    public function hangupByCustomer()
    {

    }
}
