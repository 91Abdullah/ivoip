<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Auth;
use App\Workcode;
use Setting;

class FrontOutboundController extends Controller
{
    public function index()
    {
    	$user = Auth::user();
    	$server = Setting::get('host');
    	$workcodes = Workcode::where("type", "Outbound")->pluck('name', 'name');
    	// $server = "192.168.1.109";
    	return view('front_outbound.index', compact('user', 'server', 'workcodes'));
    }

    public function nIndex()
    {
        $user = Auth::user();
        $server = Setting::get('host');
        $workcodes = Workcode::where("type", "Outbound")->pluck('name', 'name');
        $sipPort = Setting::get('sip_port');
        $contacts = Contact::all(['name', 'number']);
        return view('front_outbound.nIndex', compact('user', 'server', 'workcodes', 'contacts', 'sipPort'));
    }
}
