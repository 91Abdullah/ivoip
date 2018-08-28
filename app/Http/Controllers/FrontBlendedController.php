<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Workcode;
use App\AgentBreak;
use Auth;

class FrontBlendedController extends Controller
{
    public function index()
    {
    	$user = Auth::user();
    	$server = "10.0.0.217";
    	// $server = "192.168.1.109";
    	$queues = Auth::user()->queues->pluck('name');
    	$workcodes = Workcode::pluck('name', 'name');
    	$breaks = AgentBreak::pluck('name');
    	return view('front_blended.index', compact('user', 'server', 'queues', 'workcodes', 'breaks'));
    }
}
