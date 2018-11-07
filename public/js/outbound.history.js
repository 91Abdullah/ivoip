

$(function () {
    mHistory.init();
});

let mHistory;
let cHistory;
let ccHistory;

mHistory = {
    init: function () {
        this.getCalls();
        this.getContacts()
    },
    getCalls: function () {
        cHistory = $("#callsTable").DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            searching: true,
            ordering: true,
            filter: false,
            sorting: false,
            info: false,
            responsive: false,
            retrieve: true,
            pageLength: 5,
            lengthMenu: false,
            lengthChange: false,
            ajax: {
                url: callsUrl,
                type: 'POST',
                data: function (data) {
                    data._token = token;
                    data.userId = user;
                },
                error: function (event) {
                    toastr.error(event.statusText);
                }
            },
            columns: [
                {data: 'src'},
                {data: 'dst'},
                {data: 'start'},
                {data: 'answer'},
                {data: 'end'},
                {data: 'duration'},
                {data: 'billsec'},
                {data: 'disposition'},
                {data: 'uniqueid', fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).html("<audio controls><source src='agent/play/" + sData + ".wav'>Your browser does not support the audio element.</audio>");}}
            ]
        });
    },
    getContacts: function () {
        ccHistory = $("#contactsTable").DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            searching: true,
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
                url: contactsUrl,
                type: 'POST',
                data: function (data) {
                    data._token = token;
                },
                error: function (event) {
                    toastr.error(event.statusText);
                }
            },
            columns: [
                {data: 'name'},
                {data: 'number'}
            ]
        });
    },
    updateCalls: function () {
        if($.fn.dataTable.isDataTable('#callsTable')) {
            cHistory.ajax.reload();
        }
    },
    error: function (data) {
        console.log(data);
        toastr.error('Request failed with error: ');
    }
};