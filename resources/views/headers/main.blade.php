<!-- BEGIN: Header -->
<header style="z-index: 9999;" id="m_header" class="m-grid__item m-header" minimize-offset="200" minimize-mobile-offset="200" >
	<div class="m-container m-container--fluid m-container--full-height">
		<div class="m-stack m-stack--ver m-stack--desktop">
			
			@include('headers.brand')

			<div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">

				@include('headers.horizontal-menu')

				@include('headers.top-bar')
			</div>
		</div>
	</div>
</header>
<!-- END: Header -->	