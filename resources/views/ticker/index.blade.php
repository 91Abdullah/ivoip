@extends('layouts.portlet')

@section('page-title', 'Tickers')

@section('page_sub_title', 'List of Currently active tickers')

@section('new_record_link', action('TickerController@create'))

@section('body')
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Content</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickers as $index => $ticker)
                    <tr>
                        <td>{{ $ticker->id }}</td>
                        <td>{{ $ticker->content }}</td>
                        <td>
                            <a href="{{ route('ticker.edit', $ticker) }}" class="btn btn-info">Edit</a>
                            <form method="post" action="{{ route('ticker.destroy', $ticker) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">
                            No data found in database.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection