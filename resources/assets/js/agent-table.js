
"use strict";

$(document).ready(function () {

    selectQueue.onchange = getStats();
    setInterval(getStats, 2000);

    $("#callsTab").on("show.bs.tab", function (e) {
        if(Answeredtable === undefined || UnansweredTable === undefined) {
            loadTable();
        } else {
            updateTable();
        }
    });
});

let Answeredtable = undefined;
let UnansweredTable = undefined;

// Realtime stats

let selectQueue = document.getElementById("selectq");
let selectedQ = selectQueue.options[selectQueue.selectedIndex].value;

function getStats() {
    axios.post(url_allstats, {
        queue: selectedQ,
        agent: user_extension,
    })
        .then(updateUserInterface)
        .catch(catchError);
}

function updateUserInterface(response) {
    // console.log(data);
    let agentData = response.data.agent;
    let qData = response.data.queue;

    document.getElementById("queue_calls").innerHTML = qData.calls;
    document.getElementById("queue_answered").innerHTML = qData.answered;
    document.getElementById("queue_abandoned").innerHTML = qData.abandoned;
    document.getElementById("queue_wait").innerHTML = qData.callers;
    document.getElementById("queue_avg_talk").innerHTML = qData.talktime;
    document.getElementById("queue_avg_wait").innerHTML = qData.waittime;
    document.getElementById("queue_srv_lvl").innerHTML = qData.servicelevelperf2;
    document.getElementById("queue_wait_time").innerHTML = qData.maxtime;

    // Agent stats

    document.getElementById("agent_name").innerHTML = agentData.name;
    document.getElementById("agent_callstaken").innerHTML = agentData.callstaken;
    document.getElementById("agent_lastcall").innerHTML = agentData.lastcall;
    document.getElementById("agent_lastnotready").innerHTML = agentData.lastpause;
    document.getElementById("agent_notready").innerHTML = agentData.paused;
    document.getElementById("agent_notreadyreason").innerHTML = agentData.pausedreason;
    document.getElementById("agent_currentstatus").innerHTML = agentData.status;
    document.getElementById("agent_busy").innerHTML = agentData.incall;

}

function catchError(error) {
    toastr.error(error);
}

// End Realtime stats

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
                $(nTd).html("<audio controls><source src='agent/play/" + sData + ".wav'>Your browser does not support the audio element.</audio>");}},
            {data: 'agent'},
            {data: 'queue'},
            {data: 'holdtime'},
            {data: 'calltime'},
            {data: 'queue_pos'}
        ]
    });
}
