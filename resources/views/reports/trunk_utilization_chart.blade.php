
@extends('layouts.reports')

@section('page_sub_title', 'Trunk Utilization Report')

@push('styles')
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/r-2.2.2/datatables.min.css"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/table.css') }}">
@endpush

@section('body')

	{!! Form::open(['method' => 'POST', 'class' => 'm-form m-form--fit m-form--label-align-right m-form--state', 'id' => 'getReport']) !!}

	<div class="form-group m-form__group row {{ $errors->has('chartType') ? 'has-danger' : '' }}">
		{!! Form::label('chartType', 'Chart Type', ['class' => 'col-form-label col-lg-3 col-sm-12']) !!}
		<div class="col-lg-4 col-md-9 col-sm-12">
			{!! Form::select('chartType', ['bar' => 'Bar', 'line' => 'Line', 'pie' => 'Pie'], null, ['class' => 'form-control m-input']) !!}
			@if($errors->has('chartType'))
				<div class="form-control-feedback">{{ $errors->first('chartType') }}</div>
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

	<div id="chartContainer" class="chart-container" style="display: none;">
	    <canvas id="chart"></canvas>
	</div>

@endsection

@push('scripts')
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/r-2.2.2/datatables.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.com/libraries/Chart.js"></script>
	<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
	<script type="text/javascript">

		const getReport = document.getElementById('getReport');
		const dp = $('#m_datepicker_3');
		const url = "{!! route('report.trunk_data_graph') !!}";
		const chartType = document.getElementById("chartType");
		let ctx = document.getElementById("chart");
		let ctxContainer = document.getElementById("chartContainer");
		let myChart = undefined;

		dp.datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true
		});

		dp.on("changeDate", function(e) {
			dp.val(e.target.value);
		});

		getReport.onsubmit = function(event) {
			event.preventDefault();

			axios.get(url, {
				params: {
					date: dp.val()
				}
			})
			.then(loadChart)
			.catch(loadError)
		}

		function loadError(error)
		{
			toastr.error("Error", "Error in fetching data. Reason: " + error);
		}

		function loadChart(response)
		{
			ctxContainer.style.display = "block";
			let data = response.data;
			let awr = [];

			for (let i = 0; i < data.length; i++) {
				awr.push(data[i].count);
			}

			if(myChart == undefined) {
				myChart = new Chart(ctx, {
				    type: chartType.value,
				    data: {
				        labels: ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "16", "18", "19", "20", "21", "23"],
				        datasets: [{
				            label: '# of Calls',
				            data: awr,
				            backgroundColor: [
				                'rgba(255, 99, 132, 0.2)',
				                'rgba(54, 162, 235, 0.2)',
				                'rgba(255, 206, 86, 0.2)',
				                'rgba(75, 192, 192, 0.2)',
				                'rgba(153, 102, 255, 0.2)',
				                'rgba(255, 159, 64, 0.2)'
				            ],
				            borderColor: [
				                'rgba(255,99,132,1)',
				                'rgba(54, 162, 235, 1)',
				                'rgba(255, 206, 86, 1)',
				                'rgba(75, 192, 192, 1)',
				                'rgba(153, 102, 255, 1)',
				                'rgba(255, 159, 64, 1)'
				            ],
				            borderWidth: 1
				        }]
				    },
				    options: {
				    	responsive: true,
				        scales: {
				        	xAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Hours of Day'
								}
							}],
				            yAxes: [{
				                ticks: {
				                    beginAtZero:true
				                }
				            }]
				        }
				    }
				});
			} else {
				myChart.destroy();
				myChart = new Chart(ctx, {
				    type: chartType.value,
				    data: {
				        labels: ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "16", "18", "19", "20", "21", "23"],
				        datasets: [{
				            label: '# of Calls',
				            data: awr,
				            backgroundColor: [
				                'rgba(255, 99, 132, 0.2)',
				                'rgba(54, 162, 235, 0.2)',
				                'rgba(255, 206, 86, 0.2)',
				                'rgba(75, 192, 192, 0.2)',
				                'rgba(153, 102, 255, 0.2)',
				                'rgba(255, 159, 64, 0.2)'
				            ],
				            borderColor: [
				                'rgba(255,99,132,1)',
				                'rgba(54, 162, 235, 1)',
				                'rgba(255, 206, 86, 1)',
				                'rgba(75, 192, 192, 1)',
				                'rgba(153, 102, 255, 1)',
				                'rgba(255, 159, 64, 1)'
				            ],
				            borderWidth: 1
				        }]
				    },
				    options: {
				    	responsive: true,
				        scales: {
				        	xAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Hours of Day'
								}
							}],
				            yAxes: [{
				                ticks: {
				                    beginAtZero:true
				                }
				            }]
				        }
				    }
				});
			}
		}

	</script>
@endpush