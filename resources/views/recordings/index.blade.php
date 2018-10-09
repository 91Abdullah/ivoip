
@extends('layouts.reports')

@section('page_sub_title', 'Recordings')

@push('styles')
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/r-2.2.2/datatables.min.css"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/table.css') }}">
@endpush

@section('body')

	{!! Form::open(['method' => 'POST', 'class' => 'm-form m-form--fit m-form--label-align-right m-form--state', 'id' => 'getReport']) !!}

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

	<div class="form-group m-form__group row {{ $errors->has('queue') ? 'has-danger' : '' }}">
		{!! Form::label('queue', 'Select Queue', ['class' => 'col-form-label col-lg-3 col-sm-12']) !!}
		<div class="col-lg-4 col-md-9 col-sm-12">
			{!! Form::select('queue', App\Queue::pluck('name', 'name'), null, ['class' => 'form-control m-input']) !!}
			@if($errors->has('queue'))
				<div class="form-control-feedback">{{ $errors->first('queue') }}</div>
			@endif
		</div>	
	</div>

	<div class="row m-form__actions">
		<div class="col-lg-9 ml-lg-auto">
			{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
		</div>
	</div>

	{!! Form::close() !!}
	
	<table class="table table-custom">
	  	<thead>
	    	<tr>
	      		<th>ID</th>
	      		<th>UniqueId</th>
	      		<th>Source</th>
	      		<th>Destination</th>
	      		<th>Start</th>
	      		<th>End</th>
	      		<th>Duration</th>
	      		<th>Link</th>
	    	</tr>
	  	</thead>
	  	<tbody>
	  		<tr>
	  			<td colspan="8" class="text-center">
	  				Select Date to display data.
	  			</td>
	  		</tr>
	  	</tbody>
	</table>

@endsection

@push('scripts')
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/r-2.2.2/datatables.min.js"></script>
	<script type="text/javascript">

		const getReport = document.getElementById('getReport');
		const queue = document.getElementById('queue');
		const dp = $('#m_datepicker_3');
		let table = undefined;

		dp.datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			orientation: "bottom"
		});

		dp.on("changeDate", function(e) {
			dp.val(e.target.value);
		});

		getReport.onsubmit = function(event) {
			event.preventDefault();

			if($.fn.dataTable.isDataTable('.table')) {
				table.destroy();
			}

			table = $('.table').DataTable({
		        processing: true,
		        serverSide: true,
		        paging: true,
		        ajax: {
		        	url: '{!! route('recordings.get') !!}',
		        	type: 'GET',
		        	data: {
		        		_token: '{!! csrf_token() !!}',
		        		date: dp.val(),
		        		queue: queue.value
		        	}
		        },
		        dom: 'Bfrtip',
		        buttons: [
			        'copy', 'excel', 'pdf'
			    ],
		        columns: [
		            {data: 'id', name: 'id'},
		            {data: 'uniqueid', name: 'uniqueid'},
		            {data: 'source', name: 'source'},
		            {data: 'destination', name: 'destination'},
		            {data: 'start', name: 'start'},
		            {data: 'end', name: 'end'},
		            {data: 'duration', name: 'duration'},
		            {data: 'play', name: 'play', fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
			            $(nTd).html("<audio controls><source src='play/" + sData + "'>Your browser does not support the audio element.</audio>");
			        }}
		        ]
		    });
		}

		function loadFooter(row, data, start, end, display)
		{
			var api = this.api(), data;

			console.log(api);
 
            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column(3)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
 
            // Update footer
            $(api.column(3).footer()).html(
                (total/data.length).toFixed(2) + " seconds"
            );
		}

	</script>
@endpush