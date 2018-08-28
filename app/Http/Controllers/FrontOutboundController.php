<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Workcode;

class FrontOutboundController extends Controller
{
    public function index()
    {
    	$user = Auth::user();
    	$server = "10.0.0.217";
    	$workcodes = Workcode::where("type", "Outbound")->pluck('name', 'name');
    	// $server = "192.168.1.109";
    	return view('front_outbound.index', compact('user', 'server', 'workcodes'));
    }
}
