<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')->middleware(['auth'])->group(function () {
	Route::view('dashboard', 'dashboard.index')->name('dashboard');
	
	Route::resource('roles', 'RoleController');
	Route::resource('users', 'UserController');
	Route::resource('agents', 'AgentController');
	Route::resource('outbound', 'OutboundAgentController');
	Route::resource('blended', 'BlendedAgentController');
	Route::resource('queues', 'QueueController');
	Route::resource('workcodes', 'WorkcodeController');
	Route::resource('breaks', 'AgentBreakController');

	Route::prefix('reports')->group(function () {
		Route::get('test', 'ReportsController@index');
		Route::get('trunkUtilization', 'ReportsController@trunkUtilization');
		Route::get('agentAbandon', 'ReportsController@agentAbandon');
		Route::get('hangupByAgent', 'ReportsController@hangupByAgent');
		Route::get('hangupByCustomer', 'ReportsController@hangupByCustomer');
	});
});

Route::prefix('agent')->middleware(['auth'])->group(function () {
	Route::get('/', 'FrontAgentController@index')->name('front.agent');
});

Route::prefix('outbound')->middleware(['auth'])->group(function () {
	Route::get('/', 'FrontOutboundController@index')->name('front.outbound');
});

Route::prefix('blended')->middleware(['auth'])->group(function () {
	Route::get('/', 'FrontBlendedController@index')->name('front.blended');
});

Route::prefix('manager')->middleware(['auth'])->group(function () {
	Route::post('/login', 'AmiController@queue_login')->name('agent.login');
	Route::post('/logout', 'AmiController@queue_logout')->name('agent.logout');
	Route::post('/pause', 'AmiController@queue_pause')->name('agent.pause');
	Route::post('/unpause', 'AmiController@queue_unpause')->name('agent.unpause');
	Route::post('/log', 'AmiController@queue_log')->name('agent.log');
	Route::post('/status', 'AmiController@agent_status')->name('agent.status');
	Route::post('/stats', 'AmiController@agent_stats')->name('agent.stats');
	Route::post('/workcode', 'AmiController@agent_workcode')->name('agent.workcode');
	Route::post('/outworkcode', 'AmiController@out_workcode')->name('agent.outworkcode');
	Route::post('/hold', 'AmiController@agent_hold')->name('agent.hold');
	Route::post('/unhold', 'AmiController@agent_unhold')->name('agent.unhold');

	Route::post('/getcallid', 'AmiController@get_callid')->name('get.callid');
	Route::post('/getqueue', 'AmiController@get_queue')->name('get.queue');
	
	// Test Route
	Route::get('/agents', 'AmiController@queue_agents')->name('agent.agents');
	Route::get('/test_events', 'AmiController@test_events')->name('agent.test_events');

	// Test WS
	Route::get('/ws', 'AmiController@websocket_demo')->name('ws.demo');
	Route::get('/ami', 'AmiController@test_ami')->name('ami.demo');
});
