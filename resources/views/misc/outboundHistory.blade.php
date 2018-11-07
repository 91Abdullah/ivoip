<div class="m-portlet m-portlet--tabs">
    <div class="m-portlet__head">
        <div class="m-portlet__head-tools">
            <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_6_1" role="tab">
                        <i class="la la-cog"></i> Calls
                    </a>
                </li>
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2" role="tab">
                        <i class="la la-users"></i> Contacts
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="m-portlet__body">
        <div class="tab-content">
            <div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">
                <div class="table-responsive">
                    <table id="callsTable" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>src</th>
                            <th>dst</th>
                            <th>start</th>
                            <th>answer</th>
                            <th>end</th>
                            <th>duration</th>
                            <th>billsec</th>
                            <th>disposition</th>
                            <th>Recording</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
                <div class="table-responsive">
                    <table id="contactsTable" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Number</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>