<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Setting;

class SettingsController extends Controller
{
    public function store(Request $request)
    {
    	$settings = ['host', 'port', 'username', 'secret', 'connect_timeout', 'read_timeout', 'wallboard_username', 'wallboard_secret', 'reset_stats', 'reset_random'];

    	foreach ($settings as $key => $value) {
    		Setting::set($value, $request[$value]); 
    	}

    	return redirect()->back();
    }
}
