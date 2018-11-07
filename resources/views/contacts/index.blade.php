@extends('layouts.portlet')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/custom/datatables/datatables.bundle.css') }}">
@endpush

@section('page-title', 'Contacts')

@section('new_record_link', action('ContactController@create'))

@section('portlet-tools')
    <a href="{{ route('export.contact') }}" class="m-nav__link">
        <i class="m-nav__link-icon flaticon-file"></i>
        <span class="m-nav__link-text">
            Export
        </span>
    </a>
@endsection

@section('body')

    <div class="table-responsive">
        <table class="table table-bordered" id="m_table_1">
            <thead>
            <tr>
                <th>
                    ID
                </th>
                <th>
                    Name
                </th>
                <th>
                    Number
                </th>
                <th class="text-center">
                    Actions
                </th>
            </tr>
            </thead>
            <tbody>
            @forelse($contacts as $contact)
                <tr>
                    <td>{{ $contact->id }}</td>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->number }}</td>
                    <td class="text-center">
                        <a href="{{ route('contacts.edit', $contact->id) }}" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only" data-skin="dark" data-toggle="m-tooltip" data-placement="top" title="Edit" data-original-title="Edit">
                            <i class="fa flaticon-edit-1"></i>
                        </a>
                        {!! Form::open(['method' => 'DELETE', 'route' => ['contacts.destroy', $contact->id], 'style' => 'display:inline']) !!}
                        <button type="submit" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only" data-skin="dark" data-toggle="m-tooltip" data-placement="top" title="Delete" data-original-title="Delete">
                            <i class="fa flaticon-delete-1"></i>
                        </button>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @empty
                <td colspan="4" class="text-center">
                    No records found.
                </td>
            @endforelse
            </tbody>
        </table>
    </div>

    {!! $contacts->links() !!}

@endsection
