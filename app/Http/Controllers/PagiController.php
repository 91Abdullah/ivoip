<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PAGI\Client\Impl\ClientImpl as PagiClient;

class PagiController extends Controller
{
    public function index()
    {
    	$pagiClientOptions = array();
    	$pagiClient = PagiClient::getInstance($pagiClientOptions);
		$pagiClient->answer();
		$pagiClient->sayDigits(123);
		$pagiClient->hangup();
    }
}
