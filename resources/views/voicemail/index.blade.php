@extends('layouts.portlet')

@section('page-title', 'Voicemail Messages')

@section('body')

    <table class="table table-striped table-bordered table-hover table-checkable" id="m_table_1">
        <thead>
        <tr>
            <th>
                Mailbox
            </th>
            <th>
                CallerId
            </th>
            <th>
                DateTime
            </th>
            <th>
                MessageId
            </th>
            <th>
                Link
            </th>
        </tr>
        </thead>
        <tbody>
        @forelse($voicemails as $voicemail)
            <tr>
                <td>{{ $voicemail->mailbox }}</td>
                <td>{{ $voicemail->callerid }}</td>
                <td>{{ $voicemail->datetime }}</td>
                <td>{{ $voicemail->messageid }}</td>
                <td>
                    <audio src="{{ $voicemail->link }}" controls></audio>
                </td>
                <td>
                    {!! Form::open(['action' => ['VoicemailController@destroy', $voicemail->id], 'method' => 'DELETE', 'style' => 'display:inline']) !!}
                    <button type="submit" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only">
                        <i class="la la-trash"></i>
                    </button>
                    {!! Form::close() !!}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No records found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

@endsection
