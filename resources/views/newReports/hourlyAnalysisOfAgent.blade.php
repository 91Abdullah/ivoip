@extends('layouts.reports')

@section('page_sub_title')
    <div>
        Agent KPI Report New
        <button onclick="exportData()" type="button" class="btn btn-primary">
            <i class="fa fa-cloud-download"></i> Export
        </button>
        <a class="btn btn-default" href="{{ url()->previous() }}"><i class="fa fa-backward"></i> Back</a>
    </div>
@endsection

@section('body')
    @isset($data)
        <table id="tblStocks" class="table m-table m-table--head-bg-brand">
            <thead>
            <tr>
                <th>
                    Agent Id
                </th>
                <th>
                    Agent
                </th>
                <th>
                    Calls taken
                </th>
                <th>
                    Date
                </th>
                <th>
                    Hour
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $key => $value)
                <tr>
                    <td>{{ $value['agent_id'] }}</td>
                    <td>{{ $value['agent'] }}</td>
                    <td>{{ $value['calls_taken'] ?? 0 }}</td>
                    <td>{{ $value['date'] ?? 0 }}</td>
                    <td>{{ $value['hour'] ?? 0 }}</td>
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

                /* add a new records in the array */
                rows.push(
                    [
                        column1,
                        column2,
                        column3,
                        column4,
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
            link.setAttribute("download", "HourlyCallsAnalysisOfAgent.csv");
            document.body.appendChild(link);
            /* download the data file named "Stock_Price_Report.csv" */
            link.click();
        }
    </script>
@endpush