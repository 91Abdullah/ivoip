@extends('layouts.reports')

@section('page_sub_title', 'Select Report')

@section('body')
	
	{!! Form::open(['action' => 'ReportsController@getReport', 'method' => 'POST', 'class' => 'm-form m-form--fit m-form--label-align-right m-form--state']) !!}

	<div class="form-group m-form__group row {{ $errors->has('report') ? 'has-danger' : '' }}">
		{!! Form::label('report', 'Report Name', ['class' => 'col-form-label col-lg-3 col-sm-12']) !!}
		<div class="col-lg-4 col-md-9 col-sm-12">
			{!! Form::select('report', ['trunk_report' => 'Trunk Utilization Report'], null, ['class' => 'form-control m-input']) !!}
			@if($errors->has('report'))
				<div class="form-control-feedback">{{ $errors->first('report') }}</div>
			@endif
		</div>	
	</div>

	<div class="form-group m-form__group row">
		<label class="col-form-label col-lg-3 col-sm-12">
			Select Date
		</label>
		<div class="col-lg-4 col-md-9 col-sm-12">
			<div class="input-group date" >
				<input name="date" type="text" class="form-control m-input" {{-- value="05/20/2017" --}} value="{{ Carbon\Carbon::now()->toDateString() }}" id="m_datepicker_3"/>
				<div class="input-group-append">
					<span class="input-group-text">
						<i class="la la-calendar"></i>
					</span>
				</div>
			</div>
		</div>
	</div>

	<div class="row m-form__actions">
		<div class="col-lg-9 ml-lg-auto">
			{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
		</div>
	</div>

	{!! Form::close() !!}

@endsection

@push('scripts')
	<script type="text/javascript">
		$(document).ready(function() {

			let dp = $('#m_datepicker_3');

			dp.datepicker({
				format: 'yyyy-mm-dd',
				autoclose: true
			});

			dp.on("changeDate", function(e) {
				dp.val(e.target.value);
			});
		});
	</script>
@endpush