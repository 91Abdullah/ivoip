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
    return redirect()->route('login');
});

Route::view('/wallboard', 'wallboard.index');
Route::get('/getStats', 'WallboardController@get')->name("wallboard.stats");

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')->middleware(['auth', 'role'])->group(function () {

	Route::view('/', 'dashboard.index');

	Route::view('dashboard', 'dashboard.index')->name('dashboard');

	Route::view('settings', 'settings.index')->name('settings');
	Route::post('settings', 'SettingsController@store')->name('settings.store');

	Route::view('recordings', 'recordings.index')->name('recordings');
	Route::get('recordingsData', 'RecordingsController@getRecordings')->name('recordings.get');
	Route::get('downloadRecording/{$path}', 'RecordingsController@downloadFile')->name('download.file');
	
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

		Route::get('trunkUtilization', 'ReportsController@getTrunkUtilization');
		Route::get('trunkUtilizationData', 'ReportsController@getTrunkUtilizationData')->name('report.trunk_data');

		Route::get('trunkUtilizationGraph', 'ReportsController@getTrunkUtilizationGraph');
		Route::get('trunkUtilizationGraphData', 'ReportsController@getTrunkUtilizationGraphData')->name('report.trunk_data_graph');

		Route::get('hourlyServiceLevel', 'ReportsController@getHourlyServiceLevel');
		Route::get('hourlyServiceLevelData', 'ReportsController@getHourlyServiceLevelData')->name('report.hourly_service_level');

		Route::get('hourlyServiceLevelGraph', 'ReportsController@getHourlyServiceLevelGraph');
		Route::get('hourlyServiceLevelGraphData', 'ReportsController@getHourlyServiceLevelGraphData')->name('report.hourly_service_level_graph');

		Route::get('averageAnsweringSpeed', 'ReportsController@getAverageAnsweringSpeed');
		Route::get('averageAnsweringSpeedData', 'ReportsController@getAverageAnsweringSpeedData')->name('report.average_answering_speed');

		Route::get('averageAnsweringSpeedGraph', 'ReportsController@getAverageAnsweringSpeedGraph');
		Route::get('averageAnsweringSpeedGraphData', 'ReportsController@getAverageAnsweringSpeedGraphData')->name('report.average_answering_speed_graph');

		Route::get('agentAbandon', 'ReportsController@getAgentAbandon');
		Route::get('agentAbandonData', 'ReportsController@getAgentAbandonData')->name('report.agent_abandon');

		Route::get('agentAbandonGraph', 'ReportsController@getAgentAbandonGraph');
		Route::get('agentAbandonGraphData', 'ReportsController@getAgentAbandonGraphData')->name('report.agent_abandon_graph');

		Route::get('hangup', 'ReportsController@getHangup');
		Route::get('hangupData', 'ReportsController@getHangupData')->name('report.hangup');

		Route::get('hangupGraph', 'ReportsController@getHangupGraph');
		Route::get('hangupGraphData', 'ReportsController@getHangupGraphData')->name('report.hangup_graph');

		Route::get('hourlyCallsAnalysis', 'ReportsController@getHourlyCallsAnalysis');
		Route::get('hourlyCallsAnalysisData', 'ReportsController@getHourlyCallsAnalysisData')->name('report.hourly_calls_analysis');

		Route::get('callCenterPerformance', 'ReportsController@getCallCenterPerformance');
		Route::get('callCenterPerformanceData', 'ReportsController@getCallCenterPerformanceData')->name('report.callcenter_performance');

		Route::get('workcodeAnalysis', 'ReportsController@getWorkcodeAnalysis');
		Route::get('workcodeAnalysisData', 'ReportsController@getWorkcodeAnalysisData')->name('report.workcode_analysis');
	});
});

Route::prefix('agent')->middleware(['auth', 'role'])->group(function () {
	Route::get('/', 'FrontAgentController@index')->name('front.agent');
});

Route::prefix('outbound')->middleware(['auth', 'role'])->group(function () {
	Route::get('/', 'FrontOutboundController@index')->name('front.outbound');
});

Route::prefix('blended')->middleware(['auth', 'role'])->group(function () {
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
