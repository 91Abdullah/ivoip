<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\AgentBreak;
use App\Workcode;

class FrontAgentController extends Controller
{
    public function index()
    {
    	$user = Auth::user();
    	$server = "10.0.0.217";
    	// $server = "192.168.1.109";
    	$queues = Auth::user()->queues->pluck('name');
    	$workcodes = Workcode::where("type", "Inbound")->pluck('name', 'name');
    	$breaks = AgentBreak::pluck('name');
    	return view('front_agent.index', compact('user', 'server', 'queues', 'workcodes', 'breaks'));
    }
}
