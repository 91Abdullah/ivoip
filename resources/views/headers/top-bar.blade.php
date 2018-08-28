<!-- BEGIN: Topbar -->
<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
	<div class="m-stack__item m-topbar__nav-wrapper">
		<ul class="m-topbar__nav m-nav m-nav--inline">
			<li class="m-nav__item m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-center m-dropdown--mobile-full-width m-dropdown--skin-light	m-list-search m-list-search--skin-light" m-dropdown-toggle="click" m-dropdown-persistent="1" id="m_quicksearch" m-quicksearch-mode="dropdown">
				<a href="#" class="m-nav__link m-dropdown__toggle">
					<span class="m-nav__link-icon">
						<i class="flaticon-search-1"></i>
					</span>
				</a>
				<div class="m-dropdown__wrapper">
					<span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
					<div class="m-dropdown__inner ">
						<div class="m-dropdown__header">
							<form  class="m-list-search__form">
								<div class="m-list-search__form-wrapper">
									<span class="m-list-search__form-input-wrapper">
										<input id="m_quicksearch_input" autocomplete="off" type="text" name="q" class="m-list-search__form-input" value="" placeholder="Search...">
									</span>
									<span class="m-list-search__form-icon-close" id="m_quicksearch_close">
										<i class="la la-remove"></i>
									</span>
								</div>
							</form>
						</div>
						<div class="m-dropdown__body">
							<div class="m-dropdown__scrollable m-scrollable" data-scrollable="true" data-max-height="300" data-mobile-max-height="200">
								<div class="m-dropdown__content"></div>
							</div>
						</div>
					</div>
				</div>
			</li>
			<li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
				<a href="#" class="m-nav__link m-dropdown__toggle">
					<span class="m-topbar__userpic">
						<img src="{{ asset('assets/app/media/img/users/user3.jpg') }}" alt=""/>
					</span>
				</a>
				<div class="m-dropdown__wrapper">
					<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
					<div class="m-dropdown__inner">
						<div class="m-dropdown__header m--align-center" style="background: url({{ asset('assets/app/media/img/misc/user_profile_bg.jpg') }}); background-size: cover;">
							<div class="m-card-user m-card-user--skin-dark">
								<div class="m-card-user__pic">
									<img src="{{ asset('assets/app/media/img/users/user3.jpg') }}" alt=""/>
								</div>
								<div class="m-card-user__details">
									<span class="m-card-user__name m--font-weight-500">
										{{ Auth::user()->name }}
									</span>
									<a href="" class="m-card-user__email m--font-weight-300 m-link">
										{{ Auth::user()->email }}
									</a>
								</div>
							</div>
						</div>
						<div class="m-dropdown__body">
							<div class="m-dropdown__content">
								<ul class="m-nav m-nav--skin-light">
									<li class="m-nav__section m--hide">
										<span class="m-nav__section-text">
											Section
										</span>
									</li>
									<li class="m-nav__item">
										<a href="{{ route('logout') }}" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
											Logout
										</a>
										<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	                                        @csrf
	                                    </form>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</li>
		</ul>
	</div>
</div>
<!-- END: Topbar -->