<!-- BEGIN: Left Aside -->
<button class="m-aside-left-close m-aside-left-close--skin-light" id="m_aside_left_close_btn">
	<i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item m-aside-left m-aside-left--skin-dark">
<!-- BEGIN: Aside Menu -->
<div id="m_ver_menu" class="m-aside-menu m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark m-aside-menu--dropdown" data-menu-vertical="true" m-menu-dropdown="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500">
		<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
			<li class="m-menu__item" aria-haspopup="true" >
				<a href="{{ route('dashboard') }}" class="m-menu__link ">
					<span class="m-menu__item-here"></span>
					<i class="m-menu__link-icon flaticon-line-graph"></i>
					<span class="m-menu__link-text">
						Dashboard
					</span>
				</a>
			</li>
			<li class="m-menu__item m-menu__item--submenu" aria-haspopup="true"  m-menu-submenu-toggle="hover">
				<a href="javascript:;" class="m-menu__link m-menu__toggle">
					<span class="m-menu__item-here"></span>
					<i class="m-menu__link-icon flaticon-layers"></i>
					<span class="m-menu__link-title">
						<span class="m-menu__link-wrap">
							<span class="m-menu__link-text">
								Reports
							</span>
						</span>
					</span>
					<i class="m-menu__ver-arrow la la-angle-right"></i>
				</a>
				<div class="m-menu__submenu">
					<span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
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
				</div>
			</li>
			<li class="m-menu__item" aria-haspopup="true" >
				<a  href="{{ action('QueueController@index') }}" class="m-menu__link ">
					<span class="m-menu__item-here"></span>
					<i class="m-menu__link-icon flaticon-mark"></i>
					<span class="m-menu__link-text">
						Queues
					</span>
				</a>
			</li>
			<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  m-menu-submenu-toggle="hover">
				<a href="javascript:;" class="m-menu__link m-menu__toggle">
					<span class="m-menu__item-here"></span>
					<i class="m-menu__link-icon flaticon-users"></i>
					<span class="m-menu__link-title">
						<span class="m-menu__link-wrap">
							<span class="m-menu__link-text">
								Agents
							</span>
						</span>
					</span>
					<i class="m-menu__ver-arrow la la-angle-right"></i>
				</a>
				<div class="m-menu__submenu">
					<span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
						<li class="m-menu__item" aria-haspopup="true" >
							<a href="{{ action('AgentController@index') }}" class="m-menu__link">
								<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
								<span class="m-menu__link-text">
									Inbound
								</span>
							</a>
						</li>
						<li class="m-menu__item" aria-haspopup="true">
							<a href="{{ action('OutboundAgentController@index') }}" class="m-menu__link">
								<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
								<span class="m-menu__link-text">
									Outbound
								</span>
							</a>
						</li>
						<li class="m-menu__item" aria-haspopup="true">
							<a href="{{ action('BlendedAgentController@index') }}" class="m-menu__link">
								<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
								<span class="m-menu__link-text">
									Blended
								</span>
							</a>
						</li>
					</ul>
				</div>
			</li>
{{-- 			<li class="m-menu__item" aria-haspopup="true" >
				<a  href="{{ action('AgentController@index') }}" class="m-menu__link ">
					<span class="m-menu__item-here"></span>
					<i class="m-menu__link-icon flaticon-users"></i>
					<span class="m-menu__link-text">
						Agents
					</span>
				</a>
			</li> --}}
			<li class="m-menu__item" aria-haspopup="true" >
				<a href="{{ action('SupervisorController@index') }}" class="m-menu__link ">
					<span class="m-menu__item-here"></span>
					<i class="m-menu__link-icon flaticon-user-settings"></i>
					<span class="m-menu__link-text">
						Supervisors
					</span>
				</a>
			</li>
			<li class="m-menu__item" aria-haspopup="true" >
				<a href="{{ action('UserController@index') }}" class="m-menu__link ">
					<span class="m-menu__item-here"></span>
					<i class="m-menu__link-icon flaticon-user-ok"></i>
					<span class="m-menu__link-text">
						Users
					</span>
				</a>
			</li>
			{{--<li class="m-menu__item" aria-haspopup="true" >--}}
				{{--<a href="{{ action('RoleController@index') }}" class="m-menu__link ">--}}
					{{--<span class="m-menu__item-here"></span>--}}
					{{--<i class="m-menu__link-icon flaticon-avatar"></i>--}}
					{{--<span class="m-menu__link-text">--}}
						{{--Roles--}}
					{{--</span>--}}
				{{--</a>--}}
			{{--</li>--}}
			<li class="m-menu__item" aria-haspopup="true" >
				<a href="{{ action('WorkcodeController@index') }}" class="m-menu__link ">
					<span class="m-menu__item-here"></span>
					<i class="m-menu__link-icon flaticon-suitcase"></i>
					<span class="m-menu__link-text">
						Workcodes
					</span>
				</a>
			</li>
			<li class="m-menu__item" aria-haspopup="true" >
				<a href="{{ action('AgentBreakController@index') }}" class="m-menu__link ">
					<span class="m-menu__item-here"></span>
					<i class="m-menu__link-icon flaticon-clock-1"></i>
					<span class="m-menu__link-text">
						Breaks
					</span>
				</a>
			</li>
			<li class="m-menu__item" aria-haspopup="true" >
				<a  href="{{ route('settings') }}" class="m-menu__link ">
					<span class="m-menu__item-here"></span>
					<i class="m-menu__link-icon flaticon-settings"></i>
					<span class="m-menu__link-text">
						Settings
					</span>
				</a>
			</li>
			<li class="m-menu__item" aria-haspopup="true" >
				<a  href="{{ route('recordings') }}" class="m-menu__link ">
					<span class="m-menu__item-here"></span>
					<i class="m-menu__link-icon flaticon-multimedia"></i>
					<span class="m-menu__link-text">
						Recordings
					</span>
				</a>
			</li>
			<li class="m-menu__item" aria-haspopup="true" >
				<a  href="{{ route('system_recordings.index') }}" class="m-menu__link ">
					<span class="m-menu__item-here"></span>
					<i class="m-menu__link-icon flaticon-multimedia"></i>
					<span class="m-menu__link-text">
						System Recordings
					</span>
				</a>
			</li>
		</ul>
	</div>
	<!-- END: Aside Menu -->
</div>
<!-- END: Left Aside -->