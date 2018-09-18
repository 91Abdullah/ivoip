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
						Create New System Recording	
					</h3>
				</div>
			</div>
		</div>
		<!--begin::Form-->
		{!! Form::open(['action' => 'SystemRecordingController@store', 'method' => 'POST', 'class' => 'm-form m-form--fit m-form--label-align-right m-form--state', 'files' => true]) !!}
			<div class="m-portlet__body">
				<div class="form-group m-form__group {{ $errors->has('name') ? 'has-danger' : '' }}">
					{!! Form::label('name', 'Name') !!}
					{!! Form::text('name', old('name'), ['class' => 'form-control m-input']) !!}
					@if($errors->has('name'))
						<div class="form-control-feedback">{{ $errors->first('name') }}</div>
					@endif
				</div>
				<div class="form-group m-form__group {{ $errors->has('file') ? 'has-danger' : '' }}">
					{!! Form::file('file') !!}
					@if($errors->has('file'))
						<div class="form-control-feedback">{{ $errors->first('file') }}</div>
					@endif
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