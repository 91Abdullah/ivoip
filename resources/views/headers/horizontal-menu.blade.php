<!-- BEGIN: Horizontal Menu -->
<button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn">
	<i class="la la-close"></i>
</button>
<div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark "  >
	<ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
		<li class="m-menu__item  m-menu__item--active  m-menu__item--submenu m-menu__item--rel"  m-menu-submenu-toggle="click" aria-haspopup="true">
			<a  href="javascript:;" class="m-menu__link m-menu__toggle">
				<span class="m-menu__link-text">
					Actions
				</span>
				<i class="m-menu__hor-arrow la la-angle-down"></i>
				<i class="m-menu__ver-arrow la la-angle-right"></i>
			</a>
			<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
				<span class="m-menu__arrow m-menu__arrow--adjust"></span>
				<ul class="m-menu__subnav">
					<li class="m-menu__item  m-menu__item--active "  aria-haspopup="true">
						<a  href="inner.html" class="m-menu__link ">
							<i class="m-menu__link-icon la la-share-alt"></i>
							<span class="m-menu__link-text">
								Create New Queue
							</span>
						</a>
					</li>
					<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
						<a  href="inner.html" class="m-menu__link ">
							<i class="m-menu__link-icon la la-user"></i>
							<span class="m-menu__link-text">
								Create New Agent
							</span>
						</a>
					</li>
					<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
						<a  href="inner.html" class="m-menu__link ">
							<i class="m-menu__link-icon la la-user-secret"></i>
							<span class="m-menu__link-text">
								Create New Supervisor
							</span>
						</a>
					</li>
					<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
						<a  href="inner.html" class="m-menu__link ">
							<i class="m-menu__link-icon la la-user-plus"></i>
							<span class="m-menu__link-text">
								Create New User
							</span>
						</a>
					</li>
				</ul>
			</div>
		</li>
		<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true">
			<a  href="javascript:;" class="m-menu__link m-menu__toggle">
				<span class="m-menu__link-text">
					Reports
				</span>
				<i class="m-menu__hor-arrow la la-angle-down"></i>
				<i class="m-menu__ver-arrow la la-angle-right"></i>
			</a>
			<div class="m-menu__submenu  m-menu__submenu--fixed m-menu__submenu--left" style="width:300px;">
				<span class="m-menu__arrow m-menu__arrow--adjust"></span>
				<div class="m-menu__subnav">
					<ul class="m-menu__content">
						<li class="m-menu__item">
							<h3 class="m-menu__heading m-menu__toggle">
								<span class="m-menu__link-text">
									Reports
								</span>
								<i class="m-menu__ver-arrow la la-angle-right"></i>
							</h3>
							<ul class="m-menu__inner">
								<li class="m-menu__item" aria-haspopup="true" >
									<a href="{{ action('ReportsController@getTrunkUtilization') }}" class="m-menu__link">
										<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
										<span class="m-menu__link-text">
											Trunk Utlization Report
										</span>
									</a>
								</li>
								<li class="m-menu__item" aria-haspopup="true" >
									<a href="{{ action('ReportsController@getTrunkUtilizationGraph') }}" class="m-menu__link">
										<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
										<span class="m-menu__link-text">
											Trunk Utlization Graph
										</span>
									</a>
								</li>
								<li class="m-menu__item" aria-haspopup="true" >
									<a href="{{ action('ReportsController@getHourlyServiceLevel') }}" class="m-menu__link">
										<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
										<span class="m-menu__link-text">
											Hourly Service Level Report
										</span>
									</a>
								</li>
								<li class="m-menu__item" aria-haspopup="true" >
									<a href="{{ action('ReportsController@getHourlyServiceLevelGraph') }}" class="m-menu__link">
										<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
										<span class="m-menu__link-text">
											Hourly Service Level Graph
										</span>
									</a>
								</li>
								<li class="m-menu__item" aria-haspopup="true" >
									<a href="{{ action('ReportsController@getAverageAnsweringSpeed') }}" class="m-menu__link">
										<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
										<span class="m-menu__link-text">
											Average Answering Speed Report
										</span>
									</a>
								</li>
								<li class="m-menu__item" aria-haspopup="true" >
									<a href="{{ action('ReportsController@getAverageAnsweringSpeedGraph') }}" class="m-menu__link">
										<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
										<span class="m-menu__link-text">
											Average Answering Speed Graph
										</span>
									</a>
								</li>
								<li class="m-menu__item" aria-haspopup="true" >
									<a href="{{ action('ReportsController@getAgentAbandon') }}" class="m-menu__link">
										<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
										<span class="m-menu__link-text">
											Agent Abandon Report
										</span>
									</a>
								</li>
								<li class="m-menu__item" aria-haspopup="true" >
									<a href="{{ action('ReportsController@getAgentAbandonGraph') }}" class="m-menu__link">
										<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
										<span class="m-menu__link-text">
											Agent Abandon Graph
										</span>
									</a>
								</li>
								<li class="m-menu__item" aria-haspopup="true" >
									<a href="{{ action('ReportsController@getHangup') }}" class="m-menu__link">
										<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
										<span class="m-menu__link-text">
											Hangup Report
										</span>
									</a>
								</li>
								<li class="m-menu__item" aria-haspopup="true" >
									<a href="{{ action('ReportsController@getHangupGraph') }}" class="m-menu__link">
										<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
										<span class="m-menu__link-text">
											Hangup Graph Report
										</span>
									</a>
								</li>
								<li class="m-menu__item" aria-haspopup="true" >
									<a href="{{ action('ReportsController@getHourlyCallsAnalysis') }}" class="m-menu__link">
										<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
										<span class="m-menu__link-text">
											Hourly Calls Analysis
										</span>
									</a>
								</li>
								<li class="m-menu__item" aria-haspopup="true" >
									<a href="{{ action('ReportsController@getCallCenterPerformance') }}" class="m-menu__link">
										<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
										<span class="m-menu__link-text">
											Call Center Performance
										</span>
									</a>
								</li>
								<li class="m-menu__item" aria-haspopup="true" >
									<a href="{{ action('ReportsController@getWorkcodeAnalysis') }}" class="m-menu__link">
										<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
										<span class="m-menu__link-text">
											Workcode Analysis
										</span>
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</li>
	</ul>
</div>
<!-- END: Horizontal Menu -->								