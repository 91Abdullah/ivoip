
@extends('layouts.reports')

@section('page_sub_title', 'Call Center Performance Detail - Daily')

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
	
	<table class="table table-bordered table-responsive">
	  	<thead>
	    	<tr>
	      		<th rowspan="2">Agent Name</th>
	      		<th rowspan="2">Recieved</th>
	      		<th rowspan="2">Answered</th>
	      		<th rowspan="2">Not Answeredr</th>
	      		<th rowspan="2">Out Calls</th>
	      		<th rowspan="2">Avg Answering Delay</th>
	      		<th colspan="2">Talk Time</th>
	      		<th colspan="2">Out Time</th>
	      		<th colspan="2">ACW Time</th>
	      		<th colspan="2">Hold Time</th>
	      		<th colspan="4">Desk Durations</th>

	    	</tr>
	    	<tr>
	    		<th>Total</th>
	    		<th>Avg</th>
	    		<th>Total</th>
	    		<th>Avg</th>
	    		<th>Total</th>
	    		<th>Avg</th>
	    		<th>Total</th>
	    		<th>Avg</th>
	    		<th>OB Idle</th>
	    		<th>IB Idle</th>
	    		<th>NotRdy</th>
	    		<th>Mann.</th>
	    	</tr>
	  	</thead>
	  	<tbody>
	  		<tr>
	  			<td colspan="19" class="text-center">
	  				Select Date to display data.
	  			</td>
	  		</tr>
	  	</tbody>
	  	<tfoot>
	  		<tr>
	  			<th>Total</th>
	  			<th></th>
	  			<th></th>
	  			<th></th>
	  			<th></th>
	  			<th></th>
	  			<th></th>
	  			<th></th>
	  			<th></th>
	  			<th></th>
	  			<th></th>
	  			<th></th>
	  			<th></th>
	  			<th></th>
	  			<th></th>
	  			<th></th>
	  			<th></th>
	  			<th></th>
	  		</tr>
	  	</tfoot>
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
		        paging: false,
		        ajax: {
		        	url: '{!! route('report.callcenter_performance') !!}',
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
		        	{data: 'name', name: 'name'},
		            {data: 'recieved', name: 'recieved'},
		            {data: 'answered', name: 'answered'},
		            {data: 'notanswer', name: 'notanswer'},
		            {data: 'outcalls', name: 'outcalls'},
		            {data: 'avgAnsDelay', name: 'avgAnsDelay'},
		            {data: 'talktimeTotal', name: 'talktimeTotal'},
		            {data: 'talkTimeAvg', name: 'talkTimeAvg'},
		            {data: 'outTalkTimeTotal', name: 'outTalkTimeTotal'},
		            {data: 'outAvg', name: 'outAvg'},
		            {data: 'acwTime', name: 'acwTime'},
		            {data: 'avgAcwTime', name: 'avgAcwTime'},
		            {data: 'holdTime', name: 'holdTime'},
		            {data: 'avgHoldTime', name: 'avgHoldTime'},
		            {data: 'obIdle', name: 'obIdle'},
		            {data: 'ibIdle', name: 'ibIdle'},
		            {data: 'notRdy', name: 'notRdy'},
		            {data: 'mann', name: 'mann'}
		        ],
		        footerCallback: loadFooter
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

            for (var i = $("#DataTables_Table_0 > tfoot > tr > th").length - 1; i >= 1; i--) {
            	let arr = [6,8,10,12,14,15,16,17];
            	if(arr.includes(i)) {

            		total = api
		            	.column(i)
		            	.data()
		            	.reduce(function (a,b) {
		            		return a + intVal(b.toSeconds());
		            	}, 0);

	            	$(api.column(i).footer()).html(
		                total.toString().toHHMMSS()
		            );
            	} else {
            		total = api
		            	.column(i)
		            	.data()
		            	.reduce(function (a,b) {
		            		return intVal(a) + intVal(b);
		            	}, 0);

	            	$(api.column(i).footer()).html(
		                total
		            );
            	}
            }
		}

		String.prototype.toSeconds = function () {
		    if (!this) return null; var hms = this.split(':'); 
		    return (+hms[0]) * 60 * 60 + (+hms[1]) * 60 + (+hms[2] || 0); 
		}

		String.prototype.toHHMMSS = function () {
		    var sec_num = parseInt(this, 10); // don't forget the second param
		    var hours   = Math.floor(sec_num / 3600);
		    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
		    var seconds = sec_num - (hours * 3600) - (minutes * 60);

		    if (hours   < 10) {hours   = "0"+hours;}
		    if (minutes < 10) {minutes = "0"+minutes;}
		    if (seconds < 10) {seconds = "0"+seconds;}
		    return hours+':'+minutes+':'+seconds;
		}

	</script>
@endpush