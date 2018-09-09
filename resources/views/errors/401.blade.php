

@extends("errors.layout")

@section("code", 401)

@section("content")
	
	<div class="m-grid__item m-grid__item--fluid m-grid m-error-4" style="background-image: url({{ asset('assets/app/media/img//error/bg4.jpg') }});">
		<div class="m-error_container">
			<h1 class="m-error_number">
				401
			</h1>
			<p class="m-error_title">
				ERROR
			</p>
			<p class="m-error_description">
				Unauthorized access!
			</p>
		</div>
	</div>

@endsection