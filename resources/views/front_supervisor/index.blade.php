
@extends('layouts.front_agent')

@section('styles')
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/r-2.2.2/datatables.min.css"/>
@endsection

@section('content')

	<div class="row">
		<div class="col-lg-10 offset-lg-1">
			<div class="m-portlet">
				<div class="m-portlet__body m-portlet__body--no-padding">
					<div class="row m-row--no-padding m-row--col-separator-xl">
						<div class="col-lg-4">
							<div class="m-widget1">
								<div class="m-widget1__item">
									<div class="row m-row--no-padding align-items-center">
										<div class="col">
											<h3 class="m-widget1__title">Phone Status</h3>
										</div>
										<div class="col m--align-right">
											<span id="phone_status" class="m-widget1__number m--font-danger">Offline</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="m-widget1">
								<div class="m-widget1__item">
									<div class="row m-row--no-padding align-items-center">
										<div class="col">
											<h3 class="m-widget1__title">Mode</h3>
										</div>
										<div class="col m--align-right">
											<span id="mode_status" class="m-widget1__number m--font-danger">Inbound</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="m-widget1">
								<div class="m-widget1__item">
									<div class="row m-row--no-padding align-items-center">
										<div class="col">
											<h3 class="m-widget1__title">Device Status</h3>
										</div>
										<div class="col m--align-right">
											<span id="device_status" class="m-widget1__number m--font-danger">Offline</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	

	<div class="row">
		<div class="col-lg-10 offset-lg-1">
			<div class="m-portlet m-portlet--mobile m-portlet--body-progress">
				<div class="m-portlet__body text-center">
					<div class="btn-group btn-group-lg" role="group" aria-label="Large button group">
					   	<button data-reason="null" id="ready_btn" type="button" class="btn btn-outline-primary m-btn m-btn--icon">
					   		<span>
								<i class="la la-check-circle"></i>
								<span>Ready</span>
							</span>
					   	</button>
					   	<button id="change_mode" type="button" class="btn btn-outline-primary">
					   		<span>
								<i class="la la-bullseye"></i>
								<span>Mode</span>
							</span>
					   	</button>
					   	<button id="not_ready_btn" data-toggle="dropdown" type="button" class="btn btn-outline-primary dropdown-toggle">
					   		<span>
								<i class="la la-close"></i>
								<span>Not Ready</span>
							</span>
					   	</button>
					   	<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					   		@foreach($breaks as $break)
					   			<button data-reason="{{ $break }}" class="dropdown-item notready_btn" data-toggle="m-tooltip" title="{{ $break }}" data-placement="right" data-skin="dark" data-container="body">{{ $break }}</button>
					   		@endforeach
					  	</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="display: none;" id="supervisor_mode">
		<div class="col-lg-10 offset-lg-1">
			<div class="m-portlet m-portlet--tabs m-portlet--skin-light">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<span class="m-portlet__head-icon">
								<i class="flaticon-statistics"></i>
							</span>
							<h3 class="m-portlet__head-text">
								Supervisor Panel
							</h3>
						</div>			
					</div>
					<div class="m-portlet__head-tools">
						<ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--right m-tabs-line-danger" role="tablist">
							<li class="nav-item m-tabs__item">
								<a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_portlet_tab_1_1" role="tab" aria-selected="true">
									Calls
								</a>
							</li>
							<li class="nav-item m-tabs__item">
								<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_tab_1_2" role="tab" aria-selected="false">
									Agents
								</a>
							</li>
						</ul>
					</div>
				</div>
				
				<div class="m-portlet__body">
					<div class="tab-content">
						<div class="tab-pane active show" id="m_portlet_tab_1_1">
							<div class="row">
								<div class="col">
									<button id="refresh_calls" class="btn btn-success float-right">Refresh</button>
								</div>
							</div>
							<table id="table_calls" class="table m-table m-table--head-bg-primary">
							  	<thead>
							    	<tr>
							      		<th>Channel</th>
							      		<th>Chn State</th>
							      		<th>Chn State Desc</th>
							      		<th>Calleridnum</th>
							      		<th>Calleridname</th>
							      		<th>Connectedlinenum</th>
							      		<th>Spy</th>
							      		<th>Whisper</th>
							      		<th>Barge</th>
							      		<th>Connectedlinename</th>
							      		<th>Exten</th>
							      		<th>Application</th>
							      		<th>Applicationdata</th>
							      		<th>Duration</th>
							    	</tr>
							  	</thead>
							  	<tbody>
							    	<tr>
							    		
							    	</tr>
							  	</tbody>
							</table>
						</div>
						<div class="tab-pane" id="m_portlet_tab_1_2">
							<div class="row">
								<div class="col">
									<button id="refresh_agents" class="btn btn-primary float-right">Refresh</button>
								</div>
							</div>
							<table id="table_queues" class="table m-table m-table--head-bg-success">
							  	<thead>
							    	<tr>
							      		<th>Queue</th>
							      		<th>Name</th>
							      		<th>State Interface</th>
							      		<th>Calls Taken</th>
							      		<th>Last Call</th>
							      		<th>Last Pause</th>
							      		<th>In Call</th>
							      		<th>Status</th>
							      		<th>Paused</th>
							      		<th>Paused Reason</th>
							      		<th>Logout</th>
							      		<th>Not Ready</th>
							    	</tr>
							  	</thead>
							  	<tbody>
							    	<tr>
							    		
							    	</tr>
							  	</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="outcall_dialer" class="row" style="display: none;">
		<div class="col-lg-6 offset-lg-3">
			<div class="m-portlet m-portlet--mobile m-portlet--body-progress">
				<div class="m-portlet__body">
					<div class="form-group m-form__group">
						<div class="m-input-icon m-input-icon--left">
							<input id="outbound_number" type="text" class="form-control form-control-lg m-input" placeholder="Number">
							<span class="m-input-icon__icon m-input-icon__icon--left">
								<span><i class="la la-phone"></i></span>
							</span>
						</div>
					</div>
					<div class="text-center">
						<button id="outcall_dial" class="btn btn-danger">Call</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="incall_info" class="row" style="display: none;">
		<div class="col-lg-6 offset-lg-3">
			<div class="m-portlet m-portlet--mobile m-portlet--body-progress">
				<div class="m-portlet__body">
					<h4 class="text-center" id="call_number">
						03350362957
					</h4>
					<h5 id="timer" class="text-center">
						00:00:00
					</h5>
					<div class="text-center">
						<span id="incall_status_text" style="color:green;" class="badge badge-roundless badge-important">
							INCALL
						</span>
					</div>
					<div class="text-center">
						<button id="incall_hangup" class="btn btn-danger">Hangup</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="incall_controls" class="row" style="display: none;">
		<div class="col-lg-6 offset-lg-3">
			<div class="m-portlet m-portlet--mobile m-portlet--body-progress">
				<div class="m-portlet__body m-portlet__body--no-padding">
					<div class="row m-row--no-padding m-row--col-separator-xl">
						<div class="col-lg-6">
							<div class="m-widget1">
								<div class="m-widget1__item">
									<div class="row m-row--no-padding align-items-center">
										<div class="col">
											<h3 class="m-widget1__title">Mute</h3>
										</div>
										<div class="col m--align-right">
											<span class="m-widget1__number m--font-danger">
												<span class="m-bootstrap-switch m-bootstrap-switch--pill m-bootstrap-switch--air">
													<input id="incall_controls_mute"data-switch="true" type="checkbox" data-on-color="danger">
												</span>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="m-widget1">
								<div class="m-widget1__item">
									<div class="row m-row--no-padding align-items-center">
										<div class="col">
											<h3 class="m-widget1__title">Hold</h3>
										</div>
										<div class="col m--align-right">
											<span class="m-widget1__number m--font-danger">
												<span class="m-bootstrap-switch m-bootstrap-switch--pill m-bootstrap-switch--air">
													<input id="incall_controls_hold"data-switch="true" type="checkbox" data-on-color="danger">
												</span>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div style="display: none;" class="row" id="history_call_parent">
		<div class="col-lg-6 offset-lg-3">
			<div class="m-portlet m-portlet--mobile m-portlet--body-progress">
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<span class="m-portlet__head-icon">
								<i class="flaticon-multimedia"></i>
							</span>
							<h3 class="m-portlet__head-text">
								Call History
							</h3>
						</div>			
					</div>
				</div>
				<div class="m-portlet__body">
					<ul id="call_history">
						
					</ul>
				</div>
			</div>
		</div>
	</div>

	<audio id="remoteAudio"></audio>
    <audio id="localAudio" muted="muted"></audio>
    <audio id="incomingRing" loop="loop" src="{{ asset("storage/home.wav") }}"></audio>
    <audio id="ringBack" loop="loop" src="{{ asset("storage/ringback.wav") }}"></audio>

	<!--begin::Modal-->
	<div class="modal fade" id="m_incoming_call" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm" role="document">
	    <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Incoming Call</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
  			<div class="modal-body">
  				<h2 id="m_incoming_call_number" class="m--font-info">
  					
  				</h2>
	      	</div>
	      	<div class="modal-footer">
				<button id="m_incoming_call_accept" type="button" class="btn btn-primary">Answer</button>
				<button id="m_incoming_call_dismiss" type="button" class="btn btn-danger" data-dismiss="modal">Dismiss</button>
	      	</div>
	    </div>
	  </div>
	</div>
	<!--end::Modal-->



@endsection

@push('scripts')
	<script type="text/javascript" src="{{ asset('js/bootstrap-switch.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/sip.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/easytimer.js') }}"></script>
	<script type="text/javascript">

		// "use strict";

		// Important variables
		const ring = document.getElementById("incomingRing");
		const ringBack = document.getElementById("ringBack");

		const user_extension = "{!! $user->extension !!}";
		const user_name = "{!! $user->name !!}";
		const sip_password = "{!! $user->secret !!}";
		const user_id = "{!! $user->id !!}";

		const server = "{!! $server !!}";
		const queues = {!! $queues !!};
		const workcodes = {!! $workcodes !!};

		const url_login = "{!! route('agent.login') !!}";
		const url_logout = "{!! route('agent.logout') !!}";
		const url_pause = "{!! route('agent.pause') !!}";
		const url_unpause = "{!! route('agent.unpause') !!}";
		const url_status = "{!! route('agent.status') !!}";
		const url_stats = "{!! route('agent.stats') !!}";
		const url_callid = "{!! route('get.callid') !!}";
		const url_queue = "{!! route('get.queue') !!}";
		const url_workcode = "{!! route('agent.workcode') !!}";
		const url_hold = "{!! route('agent.hold') !!}";
		const url_unhold = "{!! route('agent.unhold') !!}";

		const url_outworkcode = "{{ route('agent.outworkcode') }}";

		const url_supervisor_agents = "{!! route('supervisor.agents') !!}";
		const url_supervisor_calls = "{!! route('supervisor.calls') !!}";
		const url_supervisor_spy = "{!! route('supervisor.spy') !!}";
		
		const token = "{!! csrf_token() !!}";

		const pause_buttons = document.getElementsByClassName("notready_btn");

		const timer = new Timer();

		let callId = [];
		let uniqueId = [];
		let forQueue = undefined;
	</script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/r-2.2.2/datatables.min.js"></script>
	<script type="text/javascript" src="{{ asset('js/supervisor.js') }}"></script>
@endpush