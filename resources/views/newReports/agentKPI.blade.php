@extends('layouts.reports')

@section('page_sub_title', 'Agent KPI Report')

@section('body')
    <form class="m-form m-form--fit m-form--label-align-right" method="post" action="{{ action('NewReportController@getAgentKPIReportData') }}">
        @csrf
        <div class="form-group m-form__group row">
            <label for="example-month-input" class="col-2 col-form-label">
                Month / Year
            </label>
            <div class="col-10">
                <input name="date" class="form-control m-input" type="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
            </div>
        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                        <button type="submit" class="btn btn-success">
                            Generate
                        </button>
                        <button onclick="exportData()" type="button" class="btn btn-primary">
                            Export
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="m-portlet m-portlet--skin-dark m-portlet--bordered-semi">
        <div class="m-portlet__body">
            @isset($query)
                <br />
                <br />
                Query date/time: {{ $query ?? '' }}
            @endisset
            <br />
            <br />
            <b>Avg hold time</b> indicates average of customer's wait time in queue
            <br />
            <br />
            If <b>Time in queue</b> of some agent shows '0' that probably means agent hasn't logged out yet or previously due to which system failed to capture logged out time of that agent.
        </div>
    </div>

    @isset($data)
        <table id="tblStocks" class="table m-table m-table--head-bg-brand">
            <thead>
            <tr>
                <th>
                    Agent
                </th>
                <th>Time in queue</th>
                <th>
                    Avg talk time
                </th>
                <th>
                    Calls answered
                </th>
                <th>
                    Total calls missed
                </th>
                <th>
                    Avg hold time
                </th>
                <th>
                    Avg answering speed
                </th>
                <th>
                    Avg ring time
                </th>
                <th>
                    Avg calls abandoned
                </th>
                <th>
                    Avg calls dropped
                </th>
                <th>
                    Avg call time
                </th>
                <th>
                    Call handling time
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $key => $value)
                <tr>
                    <td>{{ $key }}</td>
                    <td>{{ $value['time_in_queue'] ?? 0 }}</td>
                    <td>{{ $value['avg_talk_time'] ?? 0 }}</td>
                    <td>{{ $value['total_calls_answered'] ?? 0 }}</td>
                    <td>{{ $value['total_calls_drop'] ?? 0 }}</td>
                    <td>{{ $value['avg_hold_time'] ?? 0 }}</td>
                    <td>{{ $value['avg_ans_speed'] ?? 0 }}</td>
                    <td>{{ $value['avg_ring_time'] ?? 0 }}</td>
                    <td>{{ $value['calls_abandoned'] ?? 0 }}</td>
                    <td>{{ $value['calls_drop'] ?? 0 }}</td>
                    <td>{{ $value['avg_call_time'] ?? 0 }}</td>
                    <td>{{ !isset($value['avg_call_time']) ? 0 : round($value['avg_talk_time']/(int)$value['avg_call_time'], 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endisset
@endsection

@push('scripts')
    <script>

        function exportData(){
            /* Get the HTML data using Element by Id */
            let table = document.getElementById("tblStocks");

            /* Declaring array variable */
            let rows =[];

            //iterate through rows of table
            for(let i=0,row; row = table.rows[i];i++){
                //rows would be accessed using the "row" variable assigned in the for loop
                //Get each cell value/column from the row
                column1 = row.cells[0].innerText;
                column2 = row.cells[1].innerText;
                column3 = row.cells[2].innerText;
                column4 = row.cells[3].innerText;
                column5 = row.cells[4].innerText;
                column6 = row.cells[5].innerText;
                column7 = row.cells[6].innerText;
                column8 = row.cells[7].innerText;
                column9 = row.cells[8].innerText;
                column10 = row.cells[9].innerText;
                column11 = row.cells[10].innerText;
                column12 = row.cells[11].innerText;

                /* add a new records in the array */
                rows.push(
                    [
                        column1,
                        column2,
                        column3,
                        column4,
                        column5,
                        column6,
                        column7,
                        column8,
                        column9,
                        column10,
                        column11,
                    ]
                );

            }
            let csvContent = "data:text/csv;charset=utf-8,";
            /* add the column delimiter as comma(,) and each row splitted by new line character (\n) */
            rows.forEach(function(rowArray){
                let row = rowArray.join(",");
                csvContent += row + "\r\n";
            });

            /* create a hidden <a> DOM node and set its download attribute */
            let encodedUri = encodeURI(csvContent);
            let link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "AgentKPIReport.csv");
            document.body.appendChild(link);
            /* download the data file named "Stock_Price_Report.csv" */
            link.click();
        }
    </script>
@endpush