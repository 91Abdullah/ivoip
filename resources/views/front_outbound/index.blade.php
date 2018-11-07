
@extends('layouts.front_agent')

@section('content')

	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-6 offset-lg-3">
					<div class="m-portlet">
						<div class="m-portlet__body m-portlet__body--no-padding">
							<div class="row m-row--no-padding m-row--col-separator-xl">
								<div class="col-lg-12">
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

			<div id="outcall_dialer" class="row">
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

			<div class="row">
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
		</div>
		<div class="col-lg-12">

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

		const url_status = "{!! route('agent.status') !!}";
		const url_stats = "{!! route('agent.stats') !!}";
		const url_callid = "{!! route('get.callid') !!}";
		
		const url_hold = "{!! route('agent.hold') !!}";
		const url_unhold = "{!! route('agent.unhold') !!}";

		const url_outworkcode = "{{ route('agent.outworkcode') }}";

		const token = "{!! csrf_token() !!}";

		const workcodes = {!! $workcodes !!};

		const timer = new Timer();

		let uniqueId = [];
	</script>
	<script type="text/javascript" src="{{ asset('js/outbound.js') }}"></script>
@endpush