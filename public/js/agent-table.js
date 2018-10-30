
"use strict";

let Answeredtable = undefined;
let UnansweredTable = undefined;

$(document).ready(function () {

    $("#callsTab").on("show.bs.tab", function (e) {
        if(Answeredtable === undefined || UnansweredTable === undefined) {
            loadTable();
        } else {
            updateTable();
        }
    });
});

function updateTable() {
    if($.fn.dataTable.isDataTable('#answeredCalls') || $.fn.dataTable.isDataTable('#unansweredCalls')) {
        Answeredtable.ajax.reload();
        UnansweredTable.ajax.reload();
    }
}

function loadTable() {

    UnansweredTable = $("#unansweredCalls").DataTable({
        processing: true,
        serverSide: true,
        paging: true,
        searching: false,
        ordering: true,
        filter: false,
        sorting: false,
        info: false,
        responsive: true,
        retrieve: true,
        pageLength: 5,
        lengthMenu: false,
        lengthChange: false,
        ajax: {
            url: url_callstats,
            type: 'GET',
            data: function (data) {
                data._token = '{!! csrf_token() !!}';
                data.calls = "unanswered";
                data.agent = user_name;
            },
            error: function (event) {
                toastr.error(event.statusText);
            }
        },
        columns: [
            {data: 'time'},
            {data: 'callid'},
            {data: 'queue'},
            {data: 'agent'},
            {data: 'ringtime'}
        ]
    });

    Answeredtable = $("#answeredCalls").DataTable({
        processing: true,
        serverSide: true,
        paging: true,
        searching: false,
        ordering: true,
        filter: false,
        sorting: false,
        info: false,
        responsive: true,
        retrieve: true,
        pageLength: 5,
        lengthMenu: false,
        lengthChange: false,
        ajax: {
            url: url_callstats,
            type: 'GET',
            data: function (data) {
                data._token = '{!! csrf_token() !!}';
                data.calls = "answered";
                data.agent = user_name;
            },
            error: function (event) {
                toastr.error(event.statusText);
            }
        },
        columns: [
            {data: 'time'},
            {data: 'callid', fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                $(nTd).html("<audio controls><source src='play/" + sData + ".wav'>Your browser does not support the audio element.</audio>");}},
            {data: 'agent'},
            {data: 'queue'},
            {data: 'holdtime'},
            {data: 'calltime'},
            {data: 'queue_pos'}
        ]
    });
}
