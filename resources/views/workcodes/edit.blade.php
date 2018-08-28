@extends('layouts.metronic')

@section('page-title', 'Workcodes')

@section('content')
    
	<div class="m-portlet">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<span class="m-portlet__head-icon m--hide">
					<i class="la la-gear"></i>
					</span>
					<h3 class="m-portlet__head-text">
						Edit Workcode: {{ $workcode->name }}	
					</h3>
				</div>
			</div>
		</div>
		<!--begin::Form-->
		{!! Form::model($workcode, ['action' => ['UserController@update', $workcode->id], 'method' => 'PATCH', 'class' => 'm-form m-form--fit m-form--label-align-right m-form--state']) !!}
			<div class="m-portlet__body">
				<div class="form-group m-form__group {{ $errors->has('name') ? 'has-danger' : '' }}">
					{!! Form::label('name', 'Name') !!}
					{!! Form::text('name', old('name'), ['class' => 'form-control m-input']) !!}
					@if($errors->has('name'))
						<div class="form-control-feedback">{{ $errors->first('name') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('name') ? 'has-danger' : '' }}">
					{!! Form::label('type', 'Select Type') !!}
					{!! Form::select('type', ["Inbound" => "Inbound", "Outbound" => "Outbound"], old('type'), ['class' => 'form-control m-input']) !!}
					@if($errors->has('type'))
						<div class="form-control-feedback">{{ $errors->first('type') }}</div>
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