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
		<div class="m-portlet__head-tools">
			<ul class="m-portlet__nav">
				<li class="m-portlet__nav-item">
					<a href="@yield('new_record_link')" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
						<span>
							<i class="la la-plus"></i>
							<span>
								New record
							</span>
						</span>
					</a>
				</li>
				<li class="m-portlet__nav-item"></li>
				<li class="m-portlet__nav-item">
					<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
						<a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
							<i class="la la-ellipsis-h m--font-brand"></i>
						</a>
						<div class="m-dropdown__wrapper">
							<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
							<div class="m-dropdown__inner">
								<div class="m-dropdown__body">
									<div class="m-dropdown__content">
										<ul class="m-nav">
											<li class="m-nav__section m-nav__section--first">
												<span class="m-nav__section-text">
													Quick Actions
												</span>
											</li>
											<li class="m-nav__item">
												<a href="@yield('new_record_link')" class="m-nav__link">
													<i class="m-nav__link-icon flaticon-share"></i>
													<span class="m-nav__link-text">
														Create New
													</span>
												</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</li>
			</ul>
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