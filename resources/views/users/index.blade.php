@extends('layouts.portlet')

@push('styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/custom/datatables/datatables.bundle.css') }}">
@endpush

@section('page-title', 'Users')

@section('page_sub_title', 'All Users')

@section('new_record_link', action('UserController@create'))

@section('body')
    
	<table class="table table-striped table-bordered table-hover table-checkable" id="m_table_1">
		<thead>
			<tr>
				<th>
					ID
				</th>
				<th>
					Name
				</th>
				<th>
					Email
				</th>
				<th>
					Actions
				</th>
			</tr>
		</thead>
		<tbody>
			@foreach($users as $user)
				<tr>
					<td>{{ $user->id }}</td>
					<td>{{ $user->name }}</td>
					<td>{{ $user->email }}</td>
					<td>
						<a href="{{ action('UserController@edit', $user->id) }}" class="btn btn-success m-btn m-btn--icon m-btn--icon-only">
							<i class="la la-edit"></i>
						</a>
						{!! Form::open(['action' => ['UserController@destroy', $user->id], 'method' => 'DELETE', 'style' => 'display:inline']) !!}
							<button type="submit" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only">
								<i class="la la-trash"></i>
							</button>
						{!! Form::close() !!}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

@endsection

@push('scripts')

	<script type="text/javascript" src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			options = {
				layout: {
			        theme: 'default',
			        class: 'm-datatable--brand',
			        scroll: false,
			        height: null,
			        footer: false,
			        header: true,

			        smoothScroll: {
			            scrollbarShown: true
			        },

			        spinner: {
			            overlayColor: '#000000',
			            opacity: 0,
			            type: 'loader',
			            state: 'brand',
			            message: true
			        },

			        icons: {
			            sort: {asc: 'la la-arrow-up', desc: 'la la-arrow-down'},
			            pagination: {
			                next: 'la la-angle-right',
			                prev: 'la la-angle-left',
			                first: 'la la-angle-double-left',
			                last: 'la la-angle-double-right',
			                more: 'la la-ellipsis-h'
			            },
			            rowDetail: {expand: 'fa fa-caret-down', collapse: 'fa fa-caret-right'}
			        }
			    },

			    sortable: false,

			    pagination: true,

			    search: {
			      // enable trigger search by keyup enter
			      onEnter: false,
			      // input text for search
			      input: $('#generalSearch'),
			      // search delay in milliseconds
			      delay: 400,
			    },
			};
			var datatable = $('#m_table_1').mDatatable(options);
		});
	</script>
@endpush
