@extends('layouts.portlet')

@section('page-title', 'Conference')

@section('new_record_link', action('ConferenceController@create'))

@section('body')

    <table class="table table-striped table-bordered table-hover table-checkable" id="m_table_1">
        <thead>
        <tr>
            <th>ID</th>
            <th>Conf No</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>PIN</th>
            <th>Admin PIN</th>
            <th>Opts</th>
            <th>Admin Opts</th>
            <th>Recording FileName</th>
            <th>Recording Format</th>
            <th>Max Users</th>
            <th>Members</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($conferences as $conference)
            <tr>
                <td>{{ $conference->id }}</td>
                <td>{{ $conference->confno }}</td>
                <td>{{ $conference->starttime }}</td>
                <td>{{ $conference->endtime }}</td>
                <td>{{ $conference->pin }}</td>
                <td>{{ $conference->adminpin }}</td>
                <td>{{ $conference->opts }}</td>
                <td>{{ $conference->adminopts }}</td>
                <td>{{ $conference->recordingfilename }}</td>
                <td>{{ $conference->recordingformat }}</td>
                <td>{{ $conference->maxusers }}</td>
                <td>{{ $conference->members }}</td>
                <td>
                    <a href="{{ action('ConferenceController@edit', $conference->id) }}" class="btn btn-success m-btn m-btn--icon m-btn--icon-only">
                        <i class="la la-edit"></i>
                    </a>
                    {!! Form::open(['action' => ['ConferenceController@destroy', $conference->id], 'method' => 'DELETE', 'style' => 'display:inline']) !!}
                    <button type="submit" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only">
                        <i class="la la-trash"></i>
                    </button>
                    {!! Form::close() !!}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="13">
                    No records found.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {!! $conferences->links() !!}

@endsection
