
@extends('layouts.reports')

@section('page_sub_title', 'Test Report')

@push('styles')
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
@endpush

@section('body')
	{!! $html->table() !!}
@endsection

@push('scripts')
	<script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	 {!! $html->scripts() !!}
@endpush