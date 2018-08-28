@extends('layouts.metronic')


@section('styles')

	@stack('styles')

@endsection

@section('content')

<div class="m-portlet m-portlet--mobile">
	<div class="m-portlet__head">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text">
					@yield('page_sub_title')
				</h3>
			</div>
		</div>
	</div>
	<div class="m-portlet__body">
		@yield('body')
	</div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->
@endsection

@section('scripts')

	@stack('scripts')

@endsection