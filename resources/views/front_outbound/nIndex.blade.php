
@extends('layouts.front_agent')

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/r-2.2.2/datatables.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/dialpad.css') }}">
@endpush

@section('content')

    <div class="row">
        <div class="col-lg-6">
            <div class="m-portlet">
                <div class="m-portlet__body m-portlet__body--no-padding">
                    <div class="row m-row--no-padding m-row--col-separator-xl">
                        <div class="col-lg-12">
                            <div class="m-widget1">
                                <div class="m-widget1__item">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <h3 class="m-widget1__title">Device Status</h3>
                                        </div>
                                        <div class="col m--align-right">
                                            <span id="device_status" class="m-widget1__number m--font-danger">Offline</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('misc.outboundHistory')
        </div>
        <div class="col-lg-6">
            @include('front_outbound.dialpad')
        </div>
    </div>

    @include('misc.addContact')
    @include('misc.transfer')

    <audio id="busyTone" src="{{ asset('storage/busy.mp3') }}"></audio>
    <audio id="remoteAudio"></audio>
    <audio id="localAudio" muted="muted"></audio>

@endsection

@push('scripts')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-colvis-1.5.2/b-flash-1.5.2/b-html5-1.5.2/b-print-1.5.2/r-2.2.2/datatables.min.js"></script>
    <script type="text/javascript">
        let storeUrl = "{!! route('api.contacts.create') !!}";
        let token = "{!! csrf_token() !!}";
        let user = "{!! Auth::id() !!}";
        let searchUrl = "{!! route('search.contacts') !!}";
        let extension = "{!! Auth::user()->extension !!}";
        let secret = "{!! Auth::user()->secret !!}";
        let server = "{!! $server !!}";
        let sipPort = "{!! $sipPort !!}";
        let callsUrl = "{!! route('get.outbound.calls') !!}";
        let contactsUrl = "{!! route('get.outbound.contacts') !!}";
    </script>

    <script src="{{ asset('js/easytimer.js') }}"></script>
    <script src="{{ asset('js/sip.js') }}"></script>
    <script src="{{ asset('js/transfer.js') }}"></script>
    <script src="{{ asset('js/outbound.history.js') }}"></script>
    <script src="{{ asset('js/sip-init.js') }}"></script>
    <script src="{{ asset('js/dialpad.js') }}"></script>
@endpush