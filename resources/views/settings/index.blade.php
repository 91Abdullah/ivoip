@extends('layouts.metronic')

@section('page-title', 'Settings')

@section('content')
    
	<div class="m-portlet">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<span class="m-portlet__head-icon m--hide">
					<i class="la la-gear"></i>
					</span>
					<h3 class="m-portlet__head-text">
						Application Settings	
					</h3>
				</div>
			</div>
		</div>
		<!--begin::Form-->
		{!! Form::open(['action' => 'SettingsController@store', 'method' => 'POST', 'class' => 'm-form m-form--fit m-form--label-align-right m-form--state']) !!}
			<div class="m-portlet__body">
				<div class="form-group m-form__group {{ $errors->has('host') ? 'has-danger' : '' }}">
					{!! Form::label('host', 'Host') !!}
					{!! Form::text('host', Setting::get('host'), ['class' => 'form-control m-input']) !!}
					@if($errors->has('host'))
						<div class="form-control-feedback">{{ $errors->first('host') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('port') ? 'has-danger' : '' }}">
					{!! Form::label('port', 'Port') !!}
					{!! Form::text('port', Setting::get('port'), ['class' => 'form-control m-input']) !!}
					@if($errors->has('port'))
						<div class="form-control-feedback">{{ $errors->first('port') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('username') ? 'has-danger' : '' }}">
					{!! Form::label('username', 'Username') !!}
					{!! Form::text('username', Setting::get('username'), ['class' => 'form-control m-input']) !!}
					@if($errors->has('username'))
						<div class="form-control-feedback">{{ $errors->first('username') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('secret') ? 'has-danger' : '' }}">
					{!! Form::label('secret', 'Secret') !!}
					{!! Form::text('secret', Setting::get('secret'), ['class' => 'form-control m-input']) !!}
					@if($errors->has('secret'))
						<div class="form-control-feedback">{{ $errors->first('secret') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('wallboard_username') ? 'has-danger' : '' }}">
					{!! Form::label('wallboard_username', 'Wallboard Username') !!}
					{!! Form::text('wallboard_username', Setting::get('wallboard_username'), ['class' => 'form-control m-input']) !!}
					@if($errors->has('wallboard_username'))
						<div class="form-control-feedback">{{ $errors->first('wallboard_username') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('wallboard_secret') ? 'has-danger' : '' }}">
					{!! Form::label('wallboard_secret', 'Wallboard Secret') !!}
					{!! Form::text('wallboard_secret', Setting::get('wallboard_secret'), ['class' => 'form-control m-input']) !!}
					@if($errors->has('wallboard_secret'))
						<div class="form-control-feedback">{{ $errors->first('wallboard_secret') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('connect_timeout') ? 'has-danger' : '' }}">
					{!! Form::label('connect_timeout', 'Connect Timeout') !!}
					{!! Form::text('connect_timeout', Setting::get('connect_timeout'), ['class' => 'form-control m-input']) !!}
					@if($errors->has('connect_timeout'))
						<div class="form-control-feedback">{{ $errors->first('connect_timeout') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('read_timeout') ? 'has-danger' : '' }}">
					{!! Form::label('read_timeout', 'Read Timeout') !!}
					{!! Form::text('read_timeout', Setting::get('read_timeout'), ['class' => 'form-control m-input']) !!}
					@if($errors->has('read_timeout'))
						<div class="form-control-feedback">{{ $errors->first('read_timeout') }}</div>
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