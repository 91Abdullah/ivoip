@extends('layouts.metronic')

@section('page-title', 'Dashboard')

@section('content')

	<div class="m-portlet">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<span class="m-portlet__head-icon">
						<i class="flaticon-support"></i>
					</span>
					<h3 class="m-portlet__head-text">
						Inbound Queue Stats
					</h3>
				</div>
			</div>
		</div>
		<div class="m-portlet__body m-portlet__body--no-padding">
			<div class="row m-row--no-padding m-row--col-separator-xl">
				<div class="col-lg-4">
					<div class="m-widget1">
						<div class="m-widget1__item">
							<div class="row m-row--no-padding align-items-center">
								<div class="col">
									<h3 class="m-widget1__title">Total Calls</h3>
								</div>
								<div class="col m--align-right">
									<span id="phone_status" class="m-widget1__number m--font-primary">{{ $totalCalls }}</span>
								</div>
							</div>
						</div>
						<div class="m-widget1__item">
							<div class="row m-row--no-padding align-items-center">
								<div class="col">
									<h3 class="m-widget1__title">Avg Talk Time</h3>
								</div>
								<div class="col m--align-right">
									<span id="phone_status" class="m-widget1__number m--font-primary">{{ gmdate("H:i:s", $avgTalkTime) }}</span>
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
									<h3 class="m-widget1__title">Answered</h3>
								</div>
								<div class="col m--align-right">
									<span id="device_status" class="m-widget1__number m--font-success">{{ $answered }}</span>
								</div>
							</div>
						</div>
						<div class="m-widget1__item">
							<div class="row m-row--no-padding align-items-center">
								<div class="col">
									<h3 class="m-widget1__title">Answer Rate</h3>
								</div>
								<div class="col m--align-right">
									<span id="device_status" class="m-widget1__number m--font-success">{{ round($answerRate, 2, null) . " %" }}</span>
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
									<h3 class="m-widget1__title">Abandoned</h3>
								</div>
								<div class="col m--align-right">
									<span id="device_status" class="m-widget1__number m--font-danger">{{ $abandoned }}</span>
								</div>
							</div>
						</div>
						<div class="m-widget1__item">
							<div class="row m-row--no-padding align-items-center">
								<div class="col">
									<h3 class="m-widget1__title">Abandoned Rate</h3>
								</div>
								<div class="col m--align-right">
									<span id="device_status" class="m-widget1__number m--font-danger">{{ round($abandonRate, 2, null) . " %" }}</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="m-portlet">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<span class="m-portlet__head-icon">
						<i class="flaticon-support"></i>
					</span>
					<h3 class="m-portlet__head-text">
						Outbound Calls Stats
					</h3>
				</div>
			</div>
		</div>
		<div class="m-portlet__body m-portlet__body--no-padding">
			<div class="row m-row--no-padding m-row--col-separator-xl">
				<div class="col-lg-4">
					<div class="m-widget1">
						<div class="m-widget1__item">
							<div class="row m-row--no-padding align-items-center">
								<div class="col">
									<h3 class="m-widget1__title">Total Calls</h3>
								</div>
								<div class="col m--align-right">
									<span id="phone_status" class="m-widget1__number m--font-primary">{{ $outCount }}</span>
								</div>
							</div>
						</div>
						<div class="m-widget1__item">
							<div class="row m-row--no-padding align-items-center">
								<div class="col">
									<h3 class="m-widget1__title">Answered</h3>
								</div>
								<div class="col m--align-right">
									<span id="phone_status" class="m-widget1__number m--font-primary">{{ $outAnswered }}</span>
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
									<h3 class="m-widget1__title">Total Duration</h3>
								</div>
								<div class="col m--align-right">
									<span id="device_status" class="m-widget1__number m--font-success">{{ $outDuration }}</span>
								</div>
							</div>
						</div>
						<div class="m-widget1__item">
							<div class="row m-row--no-padding align-items-center">
								<div class="col">
									<h3 class="m-widget1__title">Average Duration</h3>
								</div>
								<div class="col m--align-right">
									<span id="device_status" class="m-widget1__number m--font-success">{{ gmdate("H:i:s", $outAvg) }}</span>
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
									<h3 class="m-widget1__title">Answer Rate</h3>
								</div>
								<div class="col m--align-right">
									<span id="device_status" class="m-widget1__number m--font-danger">{{ round($outAnsRate, 2, null) . " %" }}</span>
								</div>
							</div>
						</div>
						<div class="m-widget1__item">
							<div class="row m-row--no-padding align-items-center">
								<div class="col">
									<h3 class="m-widget1__title">No Answer Rate</h3>
								</div>
								<div class="col m--align-right">
									<span id="device_status" class="m-widget1__number m--font-danger">{{ round($outNoAnsRate, 2, null) . " %" }}</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection