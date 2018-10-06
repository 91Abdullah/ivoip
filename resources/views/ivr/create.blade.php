@extends('layouts.metronic')

@section('page-title', 'IVRs')

@section('content')
    
	<div class="m-portlet">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<span class="m-portlet__head-icon m--hide">
					<i class="la la-gear"></i>
					</span>
					<h3 class="m-portlet__head-text">
						Create New IVR	
					</h3>
				</div>
			</div>
		</div>
		<!--begin::Form-->
		{!! Form::open(['action' => 'IvrController@store', 'method' => 'POST', 'class' => 'm-form m-form--fit m-form--label-align-right m-form--state']) !!}
			<div class="m-portlet__body">
				<div class="form-group m-form__group {{ $errors->has('name') ? 'has-danger' : '' }}">
					{!! Form::label('name', 'Name') !!}
					{!! Form::text('name', old('name'), ['class' => 'form-control m-input']) !!}
					@if($errors->has('name'))
						<div class="form-control-feedback">{{ $errors->first('name') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('description') ? 'has-danger' : '' }}">
					{!! Form::label('description', 'Description') !!}
					{!! Form::text('description', old('description'), ['class' => 'form-control m-input']) !!}
					@if($errors->has('description'))
						<div class="form-control-feedback">{{ $errors->first('description') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('announcement_id') ? 'has-danger' : '' }}">
					{!! Form::label('announcement_id', 'Announcement') !!}
					{!! Form::select('announcement_id', App\Announcement::pluck('description', 'id'), old('description'), ['class' => 'form-control m-input', 'placeholder' => 'None']) !!}
					@if($errors->has('announcement_id'))
						<div class="form-control-feedback">{{ $errors->first('announcement_id') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('direct_dial') ? 'has-danger' : '' }}">
					{!! Form::label('direct_dial', 'Direct Dial') !!}
					{!! Form::select('direct_dial', ['disabled'], old('direct_dial'), ['class' => 'form-control m-input']) !!}
					@if($errors->has('direct_dial'))
						<div class="form-control-feedback">{{ $errors->first('direct_dial') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('timeout') ? 'has-danger' : '' }}">
					{!! Form::label('timeout', 'Timeout') !!}
					{!! Form::number('timeout', old('timeout'), ['class' => 'form-control m-input']) !!}
					@if($errors->has('timeout'))
						<div class="form-control-feedback">{{ $errors->first('timeout') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('invalid_retries') ? 'has-danger' : '' }}">
					{!! Form::label('invalid_retries', 'Invalid Retries') !!}
					{!! Form::select('invalid_retries', ['disabled' => 'disabled', '0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10'], old('invalid_retries'), ['class' => 'form-control m-input']) !!}
					@if($errors->has('invalid_retries'))
						<div class="form-control-feedback">{{ $errors->first('invalid_retries') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('invalid_retry_recording') ? 'has-danger' : '' }}">
					{!! Form::label('invalid_retry_recording', 'Invalid Retry Recording') !!}
					{!! Form::select('invalid_retry_recording', array_change_key_case(array_merge(SystemRecording::pluck('name', 'name')->toArray(), ['none' => 'None', 'default' => 'Default']), CASE_LOWER), old('invalid_retry_recording'), ['class' => 'form-control m-input']) !!}
					@if($errors->has('invalid_retries'))
						<div class="form-control-feedback">{{ $errors->first('invalid_retries') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('append_announcement_invalid') ? 'has-danger' : '' }}">
					{!! Form::label('append_announcement_invalid', 'Append Announcement on Invalid') !!}
					{!! Form::checkbox('append_announcement_invalid', old('append_announcement_invalid'), false,['class' => 'form-control m-input']) !!}
					@if($errors->has('append_announcement_invalid'))
						<div class="form-control-feedback">{{ $errors->first('append_announcement_invalid') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('return_on_invalid') ? 'has-danger' : '' }}">
					{!! Form::label('return_on_invalid', 'Return on invalid') !!}
					{!! Form::checkbox('return_on_invalid', old('return_on_invalid'), false,['class' => 'form-control m-input']) !!}
					@if($errors->has('return_on_invalid'))
						<div class="form-control-feedback">{{ $errors->first('return_on_invalid') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('invalid_recording') ? 'has-danger' : '' }}">
					{!! Form::label('invalid_recording', 'Invalid Retry Recording') !!}
					{!! Form::select('invalid_recording', array_change_key_case(array_merge(SystemRecording::pluck('name', 'name')->toArray(), ['none' => 'None', 'default' => 'Default']), CASE_LOWER), old('invalid_recording'), ['class' => 'form-control m-input']) !!}
					@if($errors->has('invalid_recording'))
						<div class="form-control-feedback">{{ $errors->first('invalid_recording') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('invalid_destination') ? 'has-danger' : '' }}">
					{!! Form::label('invalid_destination', 'Invalid Destination') !!}
					{!! Form::select('invalid_destination', ['ivr' => 'IVR' , 'hangup' => 'Terminate Call', 'queue' => 'Queue', 'announcement' => 'Announcement'], old('invalid_recording'), ['class' => 'form-control m-input']) !!}
					@if($errors->has('invalid_destination'))
						<div class="form-control-feedback">{{ $errors->first('invalid_destination') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('invalid_destination') ? 'has-danger' : '' }}">
					{!! Form::label('invalid_destination', 'Invalid Destination') !!}
					{!! Form::select('invalid_destination', ['disabled' => 'disabled', '0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10'], old('invalid_recording'), ['class' => 'form-control m-input']) !!}
					@if($errors->has('invalid_destination'))
						<div class="form-control-feedback">{{ $errors->first('invalid_destination') }}</div>
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