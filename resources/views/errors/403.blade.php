

@extends("errors.layout")

@section("code", 403)

@section("content")
	
	<div class="m-grid__item m-grid__item--fluid m-grid m-error-4" style="background-image: url({{ asset('assets/app/media/img//error/bg4.jpg') }});">
		<div class="m-error_container">
			<h1 class="m-error_number">
				403
			</h1>
			<p class="m-error_title">
				ERROR
			</p>
			<p class="m-error_description">
				{{ $exception->getMessage() }} <br />
				<a class="btn btn-primary" href="{{ URL::previous() }}"><i class="flaticon flaticon-reply"></i> Go Back!</a>
			</p>
		</div>
	</div>

@endsection