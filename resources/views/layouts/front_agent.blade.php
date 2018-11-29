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
		<link rel="shortcut icon" href="{{ asset('assets/demo/demo3/media/img/logo/favicon_tcl.ico') }}" />
		@stack('styles')
	</head>
	<!-- end::Head -->
    <!-- end::Body -->
	<body class="m-page--wide m-header--fixed m-header--fixed-mobile m-footer--push m-aside--offcanvas-default">
		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
			
			@include('headers.front_main')

			<!-- begin::Body -->
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
				

				<div class="m-grid__item m-grid__item--fluid m-wrapper">

					<div class="m-content">
						@yield('content')
					</div>
				</div>
			</div>
			<!-- end:: Body -->
			
			@include('footers.main')

		</div>
		<!-- end:: Page -->

		@include('misc.front_quicksidebar')

	    <!-- begin::Scroll Top -->
		<div id="m_scroll_top" class="m-scroll-top">
			<i class="la la-arrow-up"></i>
		</div>
		<!-- end::Scroll Top -->		    

    	<!--begin::Base Scripts -->
		<script src="{{ asset('assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
		<script src="{{ asset('assets/demo/demo3/base/scripts.bundle.js') }}" type="text/javascript"></script>
		<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
		<!--end::Base Scripts -->   
        <!--begin::Page Snippets -->
		
		<!--end::Page Snippets -->
		@stack('scripts')
	</body>
	<!-- end::Body -->
</html>
