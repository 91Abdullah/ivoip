<div class="col-lg-6">
    <div class="m-portlet m-portlet--tabs">
        <div class="m-portlet__head">
            <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_tabs_6_1" role="tab" aria-selected="true">
                            <i class="la la-cog"></i> Queue
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2" role="tab" aria-selected="false">
                            <i class="la la-briefcase"></i> Agent
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a id="callsTab" class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_3" role="tab" aria-selected="false">
                            <i class="la la-bell-o"></i> Calls
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body m-portlet__body--no-padding">
            <div class="tab-content">
                <div class="tab-pane active show" id="m_tabs_6_1">
                    <div class="row">
                        <div class="col-lg-12 m--margin-top-5">
                            <form action="" class="m-form m-form--fit m-form--label-align-right">
                                <div class="form-group m-form__group row">
                                    <label for="selectq" class="col-3 col-form-label">Switch Queue</label>
                                    <div class="col-9">
                                        <select class="form-control m-input" name="selectq" id="selectq">
                                            @foreach($queues as $queue)
                                                <option value="{{ $queue }}">{{ $queue }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row m-row--no-padding">
                        <div class="col-lg-6">
                            <div class="m-widget1">
                                <div class="m-widget1__item">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <span class="m-widget1__title">Calls</span>
                                        </div>
                                        <div class="col m--align-right">
                                            <span id="queue_calls" class="m-widget1__number m--font-danger">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget1__item">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <span class="m-widget1__title">Answered</span>
                                        </div>
                                        <div class="col m--align-right">
                                            <span id="queue_answered" class="m-widget1__number m--font-danger">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget1__item">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <span class="m-widget1__title">Abandoned</span>
                                        </div>
                                        <div class="col m--align-right">
                                            <span id="queue_abandoned" class="m-widget1__number m--font-danger">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget1__item">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <span class="m-widget1__title">Queue Wait</span>
                                        </div>
                                        <div class="col m--align-right">
                                            <span id="queue_wait" class="m-widget1__number m--font-danger">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="m-widget1">
                                <div class="m-widget1__item">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <span class="m-widget1__title">Avg Talk</span>
                                        </div>
                                        <div class="col m--align-right">
                                            <span id="queue_avg_talk" class="m-widget1__number m--font-danger">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget1__item">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <span class="m-widget1__title">Avg Wait</span>
                                        </div>
                                        <div class="col m--align-right">
                                            <span id="queue_avg_wait" class="m-widget1__number m--font-danger">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget1__item">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <span class="m-widget1__title">Service Lvl</span>
                                        </div>
                                        <div class="col m--align-right">
                                            <span id="queue_srv_lvl" class="m-widget1__number m--font-danger">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget1__item">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <span class="m-widget1__title">Wait</span>
                                        </div>
                                        <div class="col m--align-right">
                                            <span id="queue_wait_time" class="m-widget1__number m--font-danger">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="m_tabs_6_2">
                    <div class="row m-row--no-padding">
                        <div class="col-lg-6">
                            <div class="m-widget1">
                                <div class="m-widget1__item">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <span class="m--font-boldest2">Agent Name</span>
                                        </div>
                                        <div class="col m--align-right">
                                            <span id="agent_name" class="m--font-boldest2 m--font-success">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget1__item">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <span class="m--font-boldest2">Calls Taken</span>
                                        </div>
                                        <div class="col m--align-right">
                                            <span id="agent_callstaken" class="m--font-boldest2 m--font-success">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget1__item">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <span class="m--font-boldest2">Last Call</span>
                                        </div>
                                        <div class="col m--align-right">
                                            <span id="agent_lastcall" class="m--font-boldest2 m--font-success">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget1__item">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <span class="m--font-boldest2">Last Not Ready</span>
                                        </div>
                                        <div class="col m--align-right">
                                            <span id="agent_lastnotready" class="m--font-boldest2 m--font-success">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="m-widget1">
                                <div class="m-widget1__item">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <span class="m--font-boldest2">Not Ready</span>
                                        </div>
                                        <div class="col m--align-right">
                                            <span id="agent_notready" class="m--font-boldest2 m--font-success">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget1__item">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <span class="m--font-boldest2">Last Not Ready Reason</span>
                                        </div>
                                        <div class="col m--align-right">
                                            <span id="agent_notreadyreason" class="m--font-boldest2 m--font-success">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget1__item">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <span class="m--font-boldest2">Current Status</span>
                                        </div>
                                        <div class="col m--align-right">
                                            <span id="agent_currentstatus" class="m--font-boldest2 m--font-success">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget1__item">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <span class="m--font-boldest2">Busy</span>
                                        </div>
                                        <div class="col m--align-right">
                                            <span id="agent_busy" class="m--font-boldest2 m--font-success">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="m_tabs_6_3">
                    @include('front_agent.agent-table')
                </div>

            </div>
        </div>
    </div>
</div>