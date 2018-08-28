@extends('layouts.reports')

@section('page_sub_title', 'Select Report')

@section('body')
	
	{!! Form::open(['action' => 'ReportsController@getReport', 'method' => 'POST', 'class' => 'm-form m-form--fit m-form--label-align-right m-form--state']) !!}

	<div class="form-group m-form__group {{ $errors->has('queue') ? 'has-danger' : '' }}">
		{!! Form::label('report', 'Report') !!}
		{!! Form::select('report', ['trunk_report' => 'Trunk Utilization Report'], null, ['class' => 'form-control m-input']) !!}
		@if($errors->has('report'))
			<div class="form-control-feedback">{{ $errors->first('queue') }}</div>
		@endif
	</div>

	{!! Form::close() !!}

@endsection