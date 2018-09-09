@extends("errors.layout")

@section('code', 404)

@section('content')
	
	<div class="m-grid__item m-grid__item--fluid m-grid  m-error-1" style="background-image: url({{ asset('assets/app/media/img/error/bg1.jpg') }});">
		<div class="m-error_container">
			<span class="m-error_number">
				<h1>
					404
				</h1>
			</span>
			<p class="m-error_desc">
				OOPS! Page not found.
			</p>
			<p class="m-error_desc">
				{{ $exception->getMessage() }}
			</p>
		</div>
	</div>

@endsection