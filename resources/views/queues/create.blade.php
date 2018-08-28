@extends('layouts.metronic')

@section('page-title', 'Queues')

@section('content')
    
	<div class="m-portlet">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<span class="m-portlet__head-icon m--hide">
					<i class="la la-gear"></i>
					</span>
					<h3 class="m-portlet__head-text">
						Create New Queue	
					</h3>
				</div>
			</div>
		</div>
		<!--begin::Form-->
		{!! Form::open(['action' => 'QueueController@store', 'method' => 'POST', 'class' => 'm-form m-form--fit m-form--label-align-right m-form--state']) !!}
			<div class="m-portlet__body">
				<div class="form-group m-form__group {{ $errors->has('name') ? 'has-danger' : '' }}">
					{!! Form::label('name', 'Name') !!}
					{!! Form::text('name', old('name'), ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">name of the queue</span>
					@if($errors->has('name'))
						<div class="form-control-feedback">{{ $errors->first('name') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('musiconhold') ? 'has-danger' : '' }}">
					{!! Form::label('musiconhold', 'Music On Hold') !!}
					{!! Form::text('musiconhold', 'default', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Sets the Music class on Hold (MOH) used by this queue</span>
					@if($errors->has('musiconhold'))
						<div class="form-control-feedback">{{ $errors->first('musiconhold') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('announce') ? 'has-danger' : '' }}">
					{!! Form::label('announce', 'Announce') !!}
					{!! Form::text('announce', null, ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Message to the user serving the queue. The message can be played to the user (and not to the caller) before he accepts the call, for example, to identify the queue from which the call originated, if the agent serves more than one queue.</span>
					@if($errors->has('announce'))
						<div class="form-control-feedback">{{ $errors->first('announce') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('timeout') ? 'has-danger' : '' }}">
					{!! Form::label('timeout', 'Timeout') !!}
					{!! Form::text('timeout', 15, ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">This timeout specifies how long, in seconds, the user's phone will be called before it is considered that he did not respond.</span>
					@if($errors->has('timeout'))
						<div class="form-control-feedback">{{ $errors->first('timeout') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('ringinuse') ? 'has-danger' : '' }}">
					{!! Form::label('ringinuse', 'Ring In Use') !!}
					{!! Form::select('ringinuse', ['yes' => 'yes', 'no' => 'no'], 'no', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">To avoid sending a call to the operator whose interface is in 'in use' state, set = no.</span>
					@if($errors->has('ringinuse'))
						<div class="form-control-feedback">{{ $errors->first('ringinuse') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('setinterfacevar') ? 'has-danger' : '' }}">
					{!! Form::label('setinterfacevar', 'Set Interface Variables') !!}
					{!! Form::select('setinterfacevar', ['yes' => 'yes', 'no' => 'no'], 'no', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Upon enabling it extra channel variables shall be available.</span>
					@if($errors->has('setinterfacevar'))
						<div class="form-control-feedback">{{ $errors->first('setinterfacevar') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('setqueuevar') ? 'has-danger' : '' }}">
					{!! Form::label('setqueuevar', 'Set Queue Variables') !!}
					{!! Form::select('setqueuevar', ['yes' => 'yes', 'no' => 'no'], 'no', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Upon enabling it extra queue variables shall be available.</span>
					@if($errors->has('setqueuevar'))
						<div class="form-control-feedback">{{ $errors->first('setqueuevar') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('setqueueentryvar') ? 'has-danger' : '' }}">
					{!! Form::label('setqueueentryvar', 'Set Queue Variables') !!}
					{!! Form::select('setqueueentryvar', ['yes' => 'yes', 'no' => 'no'], 'no', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Upon enabling it extra queue variables shall be available.</span>
					@if($errors->has('setqueueentryvar'))
						<div class="form-control-feedback">{{ $errors->first('setqueueentryvar') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('monitor_format') ? 'has-danger' : '' }}">
					{!! Form::label('monitor_format', 'Recording Format') !!}
					{!! Form::select('monitor_format', ['gsm' => 'gsm', 'wav' => 'wav', 'wav49' => 'wav49'], 'wav', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">To enable the recording of calls, it is required to set "monitor-format", if monitor-format is not set, recording of conversations is deemed to be turned off. Calls will be recorded only when the handset is lifted by the operator.</span>
					@if($errors->has('monitor_format'))
						<div class="form-control-feedback">{{ $errors->first('monitor_format') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('membermacro') ? 'has-danger' : '' }}">
					{!! Form::label('membermacro', 'Member Macro') !!}
					{!! Form::text('membermacro', null, ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">If set, run Macro when the connection with the operator is established.</span>
					@if($errors->has('membermacro'))
						<div class="form-control-feedback">{{ $errors->first('membermacro') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('membergosub') ? 'has-danger' : '' }}">
					{!! Form::label('membergosub', 'Member Go Sub') !!}
					{!! Form::text('membergosub', null, ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">If set, run GoSub when the connection to the agent is established.</span>
					@if($errors->has('membergosub'))
						<div class="form-control-feedback">{{ $errors->first('membergosub') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('queue_youarenext') ? 'has-danger' : '' }}">
					{!! Form::label('queue_youarenext', 'Prompt - "You are next"') !!}
					{!! Form::text('queue_youarenext', 'queue-youarenext', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Voice to be played to caller.</span>
					@if($errors->has('queue_youarenext'))
						<div class="form-control-feedback">{{ $errors->first('queue_youarenext') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('queue_thereare') ? 'has-danger' : '' }}">
					{!! Form::label('queue_thereare', 'Prompt - "There are"') !!}
					{!! Form::text('queue_thereare', 'queue-thereare', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Voice to be played to caller.</span>
					@if($errors->has('queue_thereare'))
						<div class="form-control-feedback">{{ $errors->first('queue_thereare') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('queue_callswaiting') ? 'has-danger' : '' }}">
					{!! Form::label('queue_callswaiting', 'Prompt - "Waiting calls"') !!}
					{!! Form::text('queue_callswaiting', 'queue-callswaiting', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Voice to be played to caller.</span>
					@if($errors->has('queue_callswaiting'))
						<div class="form-control-feedback">{{ $errors->first('queue_callswaiting') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('queue_quantity1') ? 'has-danger' : '' }}">
					{!! Form::label('queue_quantity1', 'Prompt - "Quantity 1"') !!}
					{!! Form::text('queue_quantity1', null, ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Voice to be played to caller.</span>
					@if($errors->has('queue_quantity1'))
						<div class="form-control-feedback">{{ $errors->first('queue_quantity1') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('queue_quantity2') ? 'has-danger' : '' }}">
					{!! Form::label('queue_quantity2', 'Prompt - "Quantity 2"') !!}
					{!! Form::text('queue_quantity2', null, ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Voice to be played to caller.</span>
					@if($errors->has('queue_quantity2'))
						<div class="form-control-feedback">{{ $errors->first('queue_quantity2') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('queue_holdtime') ? 'has-danger' : '' }}">
					{!! Form::label('queue_holdtime', 'Prompt - "The current est. Holdtime is"') !!}
					{!! Form::text('queue_holdtime', 'queue-holdtime', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Voice to be played to caller.</span>
					@if($errors->has('queue_holdtime'))
						<div class="form-control-feedback">{{ $errors->first('queue_holdtime') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('queue_minutes') ? 'has-danger' : '' }}">
					{!! Form::label('queue_minutes', 'Prompt - "Minutes"') !!}
					{!! Form::text('queue_minutes', 'queue-minutes', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Voice to be played to caller.</span>
					@if($errors->has('queue_minutes'))
						<div class="form-control-feedback">{{ $errors->first('queue_minutes') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('queue_minute') ? 'has-danger' : '' }}">
					{!! Form::label('queue_minute', 'Prompt - "Minute"') !!}
					{!! Form::text('queue_minute', 'queue-minute', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Voice to be played to caller.</span>
					@if($errors->has('queue_minute'))
						<div class="form-control-feedback">{{ $errors->first('queue_minute') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('queue_seconds') ? 'has-danger' : '' }}">
					{!! Form::label('queue_seconds', 'Prompt - "Seconds"') !!}
					{!! Form::text('queue_seconds', 'queue-seconds', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Voice to be played to caller.</span>
					@if($errors->has('queue_seconds'))
						<div class="form-control-feedback">{{ $errors->first('queue_seconds') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('queue_thankyou') ? 'has-danger' : '' }}">
					{!! Form::label('queue_thankyou', 'Prompt - "Thank you for your patience"') !!}
					{!! Form::text('queue_thankyou', 'queue-thankyou', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Voice to be played to caller.</span>
					@if($errors->has('queue_thankyou'))
						<div class="form-control-feedback">{{ $errors->first('queue_thankyou') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('queue_callerannounce') ? 'has-danger' : '' }}">
					{!! Form::label('queue_callerannounce', 'Prompt - "Caller Announce"') !!}
					{!! Form::text('queue_callerannounce', null, ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Voice to be played to caller.</span>
					@if($errors->has('queue_callerannounce'))
						<div class="form-control-feedback">{{ $errors->first('queue_callerannounce') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('queue_reporthold') ? 'has-danger' : '' }}">
					{!! Form::label('queue_reporthold', 'Prompt - "Hold Time"') !!}
					{!! Form::text('queue_reporthold', 'queue-reporthold', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Voice to be played to caller.</span>
					@if($errors->has('queue_reporthold'))
						<div class="form-control-feedback">{{ $errors->first('queue_reporthold') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('announce_frequency') ? 'has-danger' : '' }}">
					{!! Form::label('announce_frequency', 'Announce Frequency"') !!}
					{!! Form::text('announce_frequency', 0, ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">How often to announce the position in the queue and the average waiting time. If 0 then do not announce.</span>
					@if($errors->has('announce_frequency'))
						<div class="form-control-feedback">{{ $errors->first('announce_frequency') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('announce_to_first_user') ? 'has-danger' : '' }}">
					{!! Form::label('announce_to_first_user', 'Announce to First User"') !!}
					{!! Form::select('announce_to_first_user', ['yes' => 'no', 'no' => 'no'], 'no', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">If enabled, the ads will be played first in the queue. This can lead to a situation where the agent is ready to accept the call, but the connection is delayed due to the announcement and will lead to delays in the queue.</span>
					@if($errors->has('announce_to_first_user'))
						<div class="form-control-feedback">{{ $errors->first('announce_to_first_user') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('min_announce_frequency') ? 'has-danger' : '' }}">
					{!! Form::label('min_announce_frequency', 'Min Announce Frequency') !!}
					{!! Form::text('min_announce_frequency', 15, ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">The minimum interval between the moment of transition to the next position and the announcement of the average retention time. This is useful for avoiding permanent ads when the position in the subscriber queue often changes. ie, if the position in the queue has changed, then do not notify.</span>
					@if($errors->has('min_announce_frequency'))
						<div class="form-control-feedback">{{ $errors->first('min_announce_frequency') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('announce_round_seconds') ? 'has-danger' : '' }}">
					{!! Form::label('announce_round_seconds', 'Rounding level for wait-time announcements') !!}
					{!! Form::text('announce_round_seconds', 0, ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Rounding level for wait-time announcements. If 0, only minutes, not seconds, are announced; other possible values are 0, 1, 5, 10, 15, 20 and 30.[32] (For example, when set to 30, a wait time of 2:34 will be rounded to 2:30.).</span>
					@if($errors->has('announce_round_seconds'))
						<div class="form-control-feedback">{{ $errors->first('announce_round_seconds') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('announce_holdtime') ? 'has-danger' : '' }}">
					{!! Form::label('announce_holdtime', 'Announce Holdtime') !!}
					{!! Form::select('announce_holdtime', ['yes' => 'yes', 'no' => 'no', 'once' => 'once'], 'no', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Sets whether the estimated wait time will be announced after the queue position. Possible values are yes, no or once.</span>
					@if($errors->has('announce_holdtime'))
						<div class="form-control-feedback">{{ $errors->first('announce_holdtime') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('announce_position') ? 'has-danger' : '' }}">
					{!! Form::label('announce_position', 'Announce Position') !!}
					{!! Form::select('announce_position', ['yes' => 'yes', 'no' => 'no', 'limit' => 'limit', 'more'], 'no', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Announce the position in the queue? Possible values are "yes", "no", "limit", or "more".</span>
					@if($errors->has('announce_position'))
						<div class="form-control-feedback">{{ $errors->first('announce_position') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('announce_position') ? 'has-danger' : '' }}">
					{!! Form::label('announce_position_limit', 'Announce Position Limit') !!}
					{!! Form::text('announce_position_limit', 0, ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">If "limit" or "more" is assigned, announce-position will use this parameter.</span>
					@if($errors->has('announce_position_limit'))
						<div class="form-control-feedback">{{ $errors->first('announce_position_limit') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('periodic_announce') ? 'has-danger' : '' }}">
					{!! Form::label('periodic_announce', 'Prompt - "All reps busy / wait for next"') !!}
					{!! Form::text('periodic_announce', 'queue-periodic-announce', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">You can set multiple audio files for the main ad, separated by commas. The files will be played in the order listed.</span>
					@if($errors->has('periodic_announce'))
						<div class="form-control-feedback">{{ $errors->first('periodic_announce') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('periodic_announce_frequency') ? 'has-danger' : '' }}">
					{!! Form::label('periodic_announce_frequency', 'Prompt - "All reps busy / wait for next"') !!}
					{!! Form::text('periodic_announce_frequency', 60, ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">How often to do a periodic-announce.</span>
					@if($errors->has('periodic_announce_frequency'))
						<div class="form-control-feedback">{{ $errors->first('periodic_announce_frequency') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('relative_periodic_announce') ? 'has-danger' : '' }}">
					{!! Form::label('relative_periodic_announce', 'Relative Periodic Announce') !!}
					{!! Form::select('relative_periodic_announce', ['yes' => 'yes', 'no' => 'no'], 'no', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Calculate the time for periodic-announce from the moment of completion of the previous announcement, and not from its beginning. default is off.</span>
					@if($errors->has('relative_periodic_announce'))
						<div class="form-control-feedback">{{ $errors->first('relative_periodic_announce') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('random_periodic_announce') ? 'has-danger' : '' }}">
					{!! Form::label('random_periodic_announce', 'Random Periodic Announce') !!}
					{!! Form::select('random_periodic_announce', ['yes' => 'yes', 'no' => 'no'], 'no', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Do you want to be notified periodically in a random order? The default is no.</span>
					@if($errors->has('random_periodic_announce'))
						<div class="form-control-feedback">{{ $errors->first('random_periodic_announce') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('retry') ? 'has-danger' : '' }}">
					{!! Form::label('retry', 'Random Periodic Announce') !!}
					{!! Form::text('retry', 5, ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Pause before re-calling the operator for 5 seconds.</span>
					@if($errors->has('retry'))
						<div class="form-control-feedback">{{ $errors->first('retry') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('wrapuptime') ? 'has-danger' : '' }}">
					{!! Form::label('wrapuptime', 'Wrapup Time') !!}
					{!! Form::text('wrapuptime', 2, ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">After the successful call is completed, the agent rest time before he can again receive calls. by default. 0</span>
					@if($errors->has('wrapuptime'))
						<div class="form-control-feedback">{{ $errors->first('wrapuptime') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('penaltymemberslimit') ? 'has-danger' : '' }}">
					{!! Form::label('penaltymemberslimit', 'Penalty Members Limit') !!}
					{!! Form::text('penaltymemberslimit', 0, ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">do not use penalty if the queue is serving the number of operators less than or equal to what is indicated.</span>
					@if($errors->has('wrapuptime'))
						<div class="form-control-feedback">{{ $errors->first('wrapuptime') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('autofill') ? 'has-danger' : '' }}">
					{!! Form::label('autofill', 'Auto Fill') !!}
					{!! Form::select('autofill', ['yes' => 'yes', 'no' => 'no'], 'yes', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">The old, by default, behavior of the queue (autofill = no) implies a serial connection type, in which the waiting subscriber, connected to the user, only from the first position in the queue. The new default behavior, (autofill = yes) allows the waiting subscriber to connect to the queue user (agent) from any position, if there are free agents, without waiting until he takes the head position. This behavior allows you to handle calls faster and is preferable.</span>
					@if($errors->has('autofill'))
						<div class="form-control-feedback">{{ $errors->first('autofill') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('monitor_type') ? 'has-danger' : '' }}">
					{!! Form::label('monitor_type', 'Recording System') !!}
					{!! Form::text('monitor_type', 'MixMonitor', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">The MixMonitor application writes the conversation directly to one file, in contrast to the out-of-date Monitor , which separately records the inputs. ref. voice streams.</span>
					@if($errors->has('monitor_type'))
						<div class="form-control-feedback">{{ $errors->first('monitor_type') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('autopause') ? 'has-danger' : '' }}">
					{!! Form::label('autopause', 'Auto Pause') !!}
					{!! Form::select('autopause', ['yes' => 'yes', 'no' => 'no', 'all' => 'all'], 'no', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Set the operator to pause if he does not answer the call.</span>
					@if($errors->has('autopause'))
						<div class="form-control-feedback">{{ $errors->first('autopause') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('autopausedelay') ? 'has-danger' : '' }}">
					{!! Form::label('autopausedelay', 'Auto Pause Delay') !!}
					{!! Form::text('autopausedelay', 0, ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Delay the statement to pause the operator for a time, since the last failed call.</span>
					@if($errors->has('autopausedelay'))
						<div class="form-control-feedback">{{ $errors->first('autopausedelay') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('autopausebusy') ? 'has-danger' : '' }}">
					{!! Form::label('autopausebusy', 'Auto Pause Busy') !!}
					{!! Form::select('autopausebusy', ['yes' => 'yes', 'no' => 'no'], 'no', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">To set or not the operator to pause, if it is busy (BUSY).</span>
					@if($errors->has('autopausebusy'))
						<div class="form-control-feedback">{{ $errors->first('autopausebusy') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('autopauseunavail') ? 'has-danger' : '' }}">
					{!! Form::label('autopauseunavail', 'Auto Pause Unavailable') !!}
					{!! Form::select('autopauseunavail', ['yes' => 'yes', 'no' => 'no'], 'no', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Set whether or not the operator pauses if it is not available (UNAVAILABEL).</span>
					@if($errors->has('autopausebusy'))
						<div class="form-control-feedback">{{ $errors->first('autopauseunavail') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('maxlen') ? 'has-danger' : '' }}">
					{!! Form::label('maxlen', 'Maximum Length') !!}
					{!! Form::text('maxlen', 0, ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">The maximum number of people waiting in line. If exceeded, subsequent calls will be rejected. 0 is unbounded.</span>
					@if($errors->has('maxlen'))
						<div class="form-control-feedback">{{ $errors->first('maxlen') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('servicelevel') ? 'has-danger' : '' }}">
					{!! Form::label('servicelevel', 'Service Level in seconds') !!}
					{!! Form::text('servicelevel', 30, ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Calculate the percentage of calls answered during this period. For example, if servicelevel = 30 waiting in the queue for no more than 30 seconds.</span>
					@if($errors->has('servicelevel'))
						<div class="form-control-feedback">{{ $errors->first('servicelevel') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('strategy') ? 'has-danger' : '' }}">
					{!! Form::label('strategy', 'Queue Strategy') !!}
					{!! Form::select('strategy', ['ringall' => 'ringall','leastrecent' => 'leastrecent','fewestcalls' => 'fewestcalls','random' => 'random','rrmemory' => 'rrmemory','linear' => 'linear','wrandom' => 'wrandom','rrordered' => 'rrordered'], 'ringall',['class' => 'form-control m-input']) !!}
					<span class="m-form__help">The most important parameter specifies how calls between agents will be distributed.</span>
					@if($errors->has('strategy'))
						<div class="form-control-feedback">{{ $errors->first('strategy') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('joinempty') ? 'has-danger' : '' }}">
					{!! Form::label('joinempty', 'Join Empty') !!}
					{!! Form::text('joinempty', 'yes', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">The parameters of the queue "joinempty" and "leavewhenempty" regulate the conditions under which the subscriber can queue and leave it, respectively.</span>
					@if($errors->has('joinempty'))
						<div class="form-control-feedback">{{ $errors->first('joinempty') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('leavewhenempty') ? 'has-danger' : '' }}">
					{!! Form::label('leavewhenempty', 'Leave When Empty') !!}
					{!! Form::text('leavewhenempty', 'no', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">The parameters of the queue "joinempty" and "leavewhenempty" regulate the conditions under which the subscriber can queue and leave it, respectively.</span>
					@if($errors->has('leavewhenempty'))
						<div class="form-control-feedback">{{ $errors->first('leavewhenempty') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('reportholdtime') ? 'has-danger' : '' }}">
					{!! Form::label('reportholdtime', 'Report Hold Time') !!}
					{!! Form::select('reportholdtime', ['yes' => 'yes', 'no' => 'no'], 'no', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">If you need to notify the operator about how much the subscriber was waiting in the queue.</span>
					@if($errors->has('reportholdtime'))
						<div class="form-control-feedback">{{ $errors->first('reportholdtime') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('memberdelay') ? 'has-danger' : '' }}">
					{!! Form::label('memberdelay', 'Leave When Empty') !!}
					{!! Form::text('memberdelay', 0, ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">The parameter sets the delay time between the moment when the agent answers the call and connects it to the calling subscriber.</span>
					@if($errors->has('memberdelay'))
						<div class="form-control-feedback">{{ $errors->first('memberdelay') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('weight') ? 'has-danger' : '' }}">
					{!! Form::label('weight', 'Queue Weight') !!}
					{!! Form::text('weight', 0, ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">The relative importance of the queue compared to other queues. If an agent is a member of multiple queues, calls from higher-weight queues are connected first. For example, you might give an emergency queue higher weight.</span>
					@if($errors->has('weight'))
						<div class="form-control-feedback">{{ $errors->first('weight') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('timeoutrestart') ? 'has-danger' : '' }}">
					{!! Form::label('timeoutrestart', 'Timeout Restart') !!}
					{!! Form::select('timeoutrestart', ['yes' => 'yes', 'no' => 'no'], 'yes', ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Sets whether the answer-timeout of an agent is reset after a BUSY or CONGESTION signal. This can be useful for agents who are allowed to refuse calls.</span>
					@if($errors->has('timeoutrestart'))
						<div class="form-control-feedback">{{ $errors->first('timeoutrestart') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('defaultrule') ? 'has-danger' : '' }}">
					{!! Form::label('defaultrule', 'Default Rule') !!}
					{!! Form::text('defaultrule', null, ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Assign default rules.</span>
					@if($errors->has('defaultrule'))
						<div class="form-control-feedback">{{ $errors->first('defaultrule') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('timeoutpriority') ? 'has-danger' : '' }}">
					{!! Form::label('timeoutpriority', 'Timeout Priority') !!}
					{!! Form::text('timeoutpriority', null, ['class' => 'form-control m-input']) !!}
					<span class="m-form__help">Assign default rules.</span>
					@if($errors->has('timeoutpriority'))
						<div class="form-control-feedback">{{ $errors->first('timeoutpriority') }}</div>
					@endif
				</div>
			</div>
			<div class="m-portlet__foot m-portlet__foot--fit">
				<div class="m-form__actions">
					{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
					<button type="reset" class="btn btn-secondary">Cancel</button>
				</div>
			</div>
		{!! Form::close() !!}
		<!--end::Form-->			
	</div>

@endsection