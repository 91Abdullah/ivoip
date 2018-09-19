@extends('layouts.metronic')

@section('page-title', 'System Recordings')

@section('content')
    
	<div class="m-portlet">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<span class="m-portlet__head-icon m--hide">
					<i class="la la-gear"></i>
					</span>
					<h3 class="m-portlet__head-text">
						Create New Announcement
					</h3>
				</div>
			</div>
		</div>
		<!--begin::Form-->
		{!! Form::open(['action' => 'AnnouncementController@store', 'method' => 'POST', 'class' => 'm-form m-form--fit m-form--label-align-right m-form--state', 'files' => true]) !!}
			<div class="m-portlet__body">
				<div class="form-group m-form__group {{ $errors->has('description') ? 'has-danger' : '' }}">
					{!! Form::label('description', 'Description') !!}
					{!! Form::text('description', old('description'), ['class' => 'form-control m-input']) !!}
					@if($errors->has('description'))
						<div class="form-control-feedback">{{ $errors->first('description') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('system_recording_id') ? 'has-danger' : '' }}">
					{!! Form::label('system_recording_id', 'Recording') !!}
					{!! Form::select('system_recording_id', App\SystemRecording::pluck('name', 'id'), old('system_recording_id'), ['class' => 'form-control m-input']) !!}
					@if($errors->has('system_recording_id'))
						<div class="form-control-feedback">{{ $errors->first('system_recording_id') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('system_recording_id') ? 'has-danger' : '' }}">
					{!! Form::label('repeat', 'Repeat') !!}
					{!! Form::select('repeat', ['disable', '1', '2', '3', '4', '5', '6', '7', '8', '9', '*', '#'], old('repeat'), ['class' => 'form-control m-input']) !!}
					@if($errors->has('system_recording_id'))
						<div class="form-control-feedback">{{ $errors->first('system_recording_id') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('allow_skip') ? 'has-danger' : '' }}">
					{!! Form::label('Allow Skip', 'allow_skip') !!}
					{!! Form::checkbox('allow_skip', false, false) !!}
					@if($errors->has('allow_skip'))
						<div class="form-control-feedback">{{ $errors->first('allow_skip') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('return_to_ivr') ? 'has-danger' : '' }}">
					{!! Form::label('Return to IVR', 'allow_skip') !!}
					{!! Form::checkbox('return_to_ivr', false, false) !!}
					@if($errors->has('return_to_ivr'))
						<div class="form-control-feedback">{{ $errors->first('return_to_ivr') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('dont_answer_channel') ? 'has-danger' : '' }}">
					{!! Form::label('Dont\'t Answer Channel', 'dont_answer_channel') !!}
					{!! Form::checkbox('dont_answer_channel', false, false) !!}
					@if($errors->has('dont_answer_channel'))
						<div class="form-control-feedback">{{ $errors->first('dont_answer_channel') }}</div>
					@endif
				</div>
				<div class="row">
					<div class="col=lg-12 form-group m-form__group {{ $errors->has('destination') ? 'has-danger' : '' }}">
						{!! Form::label('destination', 'Destination after Playback') !!}
					</div>
					<div class="col-lg-6 form-group m-form__group {{ $errors->has('destination') ? 'has-danger' : '' }}">
						{!! Form::select('destination', ['IVR', 'Terminate Call', 'Queues'], null, ['placeholder' => 'Choose One', 'class' => 'form-control m-input']) !!}
						@if($errors->has('destination'))
							<div class="form-control-feedback">{{ $errors->first('destination') }}</div>
						@endif
					</div>
					<div class="col-lg-6 form-group m-form__group {{ $errors->has('destination') ? 'has-danger' : '' }}">
						{!! Form::select('destination_ivr', App\Ivr::pluck('name', 'id'), null, ['class' => 'form-control m-input']) !!}
					</div>
				</div>
			</div>
			<div class="m-portlet__foot m-portlet__foot--fit">
				<div class="m-form__actions">
					{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
					{{-- <button type="reset" class="btn btn-secondary">Cancel</button> --}}
					<a class="btn btn-secondary" href="{{ URL::previous() }}">Back</a>
				</div>
			</div>
		{!! Form::close() !!}
		<!--end::Form-->			
	</div>

@endsection