<!DOCTYPE html>
<html lang="en">
	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<!-- CSRF Token -->
    	<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>
			{{ config('app.name', 'Laravel') }}
		</title>
		<meta name="description" content="{{ config('app.name', 'Laravel') }}">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
          WebFont.load({
            google: {"families":["Montserrat:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
		</script>
		<!--end::Web font -->
        <!--begin::Base Styles -->
		<link href="{{ asset('assets/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/demo/demo3/base/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Base Styles -->
		<link rel="shortcut icon" href="{{ asset('assets/demo/demo3/media/img/logo/favicon.ico') }}" />
		<style type="text/css">
			.m-widget1 .m-widget1__item .m-widget1__title {
				font-size: 19px;
			}
			.la {
				font-size: 20px;
			}
			.m-widget1 .m-widget1__item .m-widget1__number {
				font-size: 22px;
			}
		</style>
	</head>
	<!-- end::Head -->
    <!-- end::Body -->
	<body  class="m-page--fluid m--skin m-content--skin-light2" >
		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">

			<!-- begin::Body -->
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

				<div class="m-grid__item m-grid__item--fluid m-wrapper">

					<div class="m-content">
						<div class="m-portlet">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<span class="m-portlet__head-icon">
											<i class="flaticon-support"></i>
										</span>
										<h3 class="m-portlet__head-text text-center">
											Live Queue Stats
										</h3>
									</div>
								</div>
							</div>
							<div class="m-portlet__body m-portlet__body--no-padding">
								<div class="row m-row--col-separator-xl">
									<div class="col-lg-4">
										<div class="m-widget1">
											<div class="m-widget1__item">
												<div class="row m-row--no-padding align-items-center">
													<div class="col">
														<h3 class="m-widget1__title"><i class="la la-phone"></i> Calls</h3>
													</div>
													<div class="col m--align-right">
														<span id="calls" class="m-widget1__number m--font-primary">0</span>
													</div>
												</div>
											</div>
											<div class="m-widget1__item">
												<div class="row m-row--no-padding align-items-center">
													<div class="col">
														<h3 class="m-widget1__title"><i class="la la-check"></i> Answered</h3>
													</div>
													<div class="col m--align-right">
														<span id="answered" class="m-widget1__number m--font-primary">0</span>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="m-widget1">
											<div class="m-widget1__item">
												<div class="row m-row--no-padding align-items-center">
													<div class="col">
														<h3 class="m-widget1__title"><i class="la la-close"></i> Abandoned</h3>
													</div>
													<div class="col m--align-right">
														<span id="abandoned" class="m-widget1__number m--font-success">0</span>
													</div>
												</div>
											</div>
											<div class="m-widget1__item">
												<div class="row m-row--no-padding align-items-center">
													<div class="col">
														<h3 class="m-widget1__title"><i class="la la-headphones"></i> Avg Talk Time</h3>
													</div>
													<div class="col m--align-right">
														<span id="avg_talk_time" class="m-widget1__number m--font-success">0</span>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="m-widget1">
											<div class="m-widget1__item">
												<div class="row m-row--no-padding align-items-center">
													<div class="col">
														<h3 class="m-widget1__title"><i class="la la-clock-o"></i> Avg Hold Time</h3>
													</div>
													<div class="col m--align-right">
														<span id="avg_hold_time" class="m-widget1__number m--font-danger">0</span>
													</div>
												</div>
											</div>
											<div class="m-widget1__item">
												<div class="row m-row--no-padding align-items-center">
													<div class="col">
														<h3 class="m-widget1__title"><i class="la la-tachometer"></i> Service Level</h3>
													</div>
													<div class="col m--align-right">
														<span id="service_lvl" class="m-widget1__number m--font-danger">0</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row m-row--col-separator-xl">
									<div class="col-lg-4">
										<div class="m-widget1">
											<div class="m-widget1__item">
												<div class="row m-row--no-padding align-items-center">
													<div class="col">
														<h3 class="m-widget1__title"><i class="la la-user"></i> Logged In</h3>
													</div>
													<div class="col m--align-right">
														<span id="loggedin" class="m-widget1__number m--font-danger">0</span>
													</div>
												</div>
											</div>
											<div class="m-widget1__item">
												<div class="row m-row--no-padding align-items-center">
													<div class="col">
														<h3 class="m-widget1__title"><i class="la la-user-plus"></i> Available</h3>
													</div>
													<div class="col m--align-right">
														<span id="available" class="m-widget1__number m--font-danger">0</span>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="m-widget1">
											<div class="m-widget1__item">
												<div class="row m-row--no-padding align-items-center">
													<div class="col">
														<h3 class="m-widget1__title"><i class="la la-hourglass-2"></i> Max Wait Time</h3>
													</div>
													<div class="col m--align-right">
														<span id="max_wait_time" class="m-widget1__number m--font-danger">0</span>
													</div>
												</div>
											</div>
											<div class="m-widget1__item">
												<div class="row m-row--no-padding align-items-center">
													<div class="col">
														<h3 class="m-widget1__title"><i class="la la-users"></i> Current Wait</h3>
													</div>
													<div class="col m--align-right">
														<span id="current_wait" class="m-widget1__number m--font-danger">0</span>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="m-widget1">
											<div class="m-widget1__item">
												<div class="row m-row--no-padding align-items-center">
													<div class="col">
														<h3 class="m-widget1__title"><i class="la la-check-circle"></i> Answer Rate</h3>
													</div>
													<div class="col m--align-right">
														<span id="answer_rate" class="m-widget1__number m--font-danger">0</span>
													</div>
												</div>
											</div>
											<div class="m-widget1__item">
												<div class="row m-row--no-padding align-items-center">
													<div class="col">
														<h3 class="m-widget1__title"><i class="la la-user-times"></i> Abandon Rate</h3>
													</div>
													<div class="col m--align-right">
														<span id="abandon_rate" class="m-widget1__number m--font-danger">0</span>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-12">
										<div id="chartContainer" class="chart-container" style="display: none;">
										    <canvas height="40" id="chart"></canvas>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- end:: Body -->
			
			

		</div>

		<!-- end:: Page -->

	    <!-- begin::Scroll Top -->
		<div id="m_scroll_top" class="m-scroll-top">
			<i class="la la-arrow-up"></i>
		</div>
		<!-- end::Scroll Top -->		    

    	<!--begin::Base Scripts -->
		<script src="{{ asset('assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
		<script src="{{ asset('assets/demo/demo3/base/scripts.bundle.js') }}" type="text/javascript"></script>
		<script type="text/javascript" src="{{ asset('js/axios.js') }}"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>
		<script type="text/javascript">
			const url = '{!! route('wallboard.stats') !!}'
			let ctx = document.getElementById("chart");
			let ctxContainer = document.getElementById("chartContainer");
			let myChart = undefined;
			let awr = 0;
			let chartType = "bar";

			$(document).ready(function(e) {
				setInterval(sendCall, 2000);
			});

			function sendCall() {
				axios.get(url)
				.then(processResponse)
				.then(loadChart)
				.catch(processError);
			}

			function processResponse(response) {
				// console.log(response);
				data1 = response.data[1];
				data0 = response.data[0];

				let calls = document.getElementById("calls");
				let answered = document.getElementById("answered");
				let abandoned = document.getElementById("abandoned");
				let avg_hold_time = document.getElementById("avg_hold_time");
				let avg_talk_time = document.getElementById("avg_talk_time");
				let service_lvl = document.getElementById("service_lvl");
				let current_wait = document.getElementById("current_wait");
				let max_wait_time = document.getElementById("max_wait_time");
				let loggedin = document.getElementById("loggedin");
				let available = document.getElementById("available");
				let answer_rate = document.getElementById("answer_rate");
				let abandon_rate = document.getElementById("abandon_rate");

				let totalCalls = parseInt(data1.completed) + parseInt(data1.abandoned);

				calls.innerHTML = totalCalls;
				answered.innerHTML = data1.completed;
				abandoned.innerHTML = data1.abandoned;
				avg_hold_time.innerHTML = data1.holdtime;
				avg_talk_time.innerHTML = data0.talktime;
				service_lvl.innerHTML = data1.servicelevelperf2 + " %";
				current_wait.innerHTML = data0.callers;
				max_wait_time.innerHTML = data0.longestholdtime;
				loggedin.innerHTML = data0.loggedin;
				available.innerHTML = data0.available;
				answer_rate.innerHTML = totalCalls == 0 ? 0 + " %" : (data1.completed/totalCalls * 100).toFixed(2) + " %";
				abandon_rate.innerHTML = totalCalls == 0 ? 0 + " %" : (data1.abandoned/totalCalls * 100).toFixed(2) + " %";
				awr = data1.servicelevelperf2;
			}

			function processError(error) {
				console.log(error);
				toastr.error(error);
			}

			function loadChart(response) {
				// console.log(response);
				ctxContainer.style.display = "block";
				if(myChart == undefined) {
					myChart = new Chart(ctx, {
					    type: 'horizontalBar',
					    data: {
					        labels: ["Service Level"],
					        datasets: [{
					            label: '% Service Level',
					            data: [awr],
					            backgroundColor: 'rgba(255, 99, 132, 0.2)',
					            borderColor: 'rgba(255,99,132,1)',
					            borderWidth: 1
					        }, {
					        	data: [100],
					        	label: '% Max',
					        	borderWidth: 1,
					        	backgroundColor: "lightgrey"
					        }]
					    },
					    options: {
					    	responsive: true,
					        scales: {
					        	xAxes: [{
									display: true,
									stacked: true,
									scaleLabel: {
										display: true,
										labelString: 'Service Level'
									},
									ticks: {
					                    beginAtZero:true,
					                    min: 0,
					                    max: 100
					                }
								}],
					            yAxes: [{
					            	display: true,
					            	stacked: true,
					                ticks: {
					                    beginAtZero:true,
					                    min: 0,
					                    max: 100
					                }
					            }]
					        }
					    }
					});
				} else if(myChart.data.datasets[0].data[0] !== awr) {
					// myChart.destroy();
					myChart.data.datasets[0].data[0] = awr;
					myChart.update();
				}
			}

		</script>
		<!--end::Base Scripts -->   
	</body>
	<!-- end::Body -->
</html>
