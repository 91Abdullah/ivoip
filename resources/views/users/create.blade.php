@extends('layouts.metronic')

@section('page-title', 'Users')

@section('content')
    
	<div class="m-portlet">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<span class="m-portlet__head-icon m--hide">
					<i class="la la-gear"></i>
					</span>
					<h3 class="m-portlet__head-text">
						Create New User	
					</h3>
				</div>
			</div>
		</div>
		<!--begin::Form-->
		{!! Form::open(['action' => 'UserController@store', 'method' => 'POST', 'class' => 'm-form m-form--fit m-form--label-align-right m-form--state']) !!}
			<div class="m-portlet__body">
				<div class="form-group m-form__group {{ $errors->has('name') ? 'has-danger' : '' }}">
					{!! Form::label('name', 'Name') !!}
					{!! Form::text('name', old('name'), ['class' => 'form-control m-input']) !!}
					@if($errors->has('name'))
						<div class="form-control-feedback">{{ $errors->first('name') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('email') ? 'has-danger' : '' }}">
					{!! Form::label('email', 'Email') !!}
					{!! Form::email('email', old('email'), ['class' => 'form-control m-input']) !!}
					@if($errors->has('email'))
						<div class="form-control-feedback">{{ $errors->first('email') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('password') ? 'has-danger' : '' }}">
					{!! Form::label('password', 'Password') !!}
					{!! Form::password('password', ['class' => 'form-control m-input', 'required' => true]) !!}
					@if($errors->has('password'))
						<div class="form-control-feedback">{{ $errors->first('password') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group">
					{!! Form::label('password_confirmation', 'Confirm Password') !!}
					{!! Form::password('password_confirmation', ['class' => 'form-control m-input', 'required' => true]) !!}
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