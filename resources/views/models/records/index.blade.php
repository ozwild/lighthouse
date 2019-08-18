@extends('layouts.master')

@section('content')

    {{ Breadcrumbs::render('records.index') }}

    <div class="vertical-spacer"></div>

    <div class="container">
        <div class="spanner"></div>
        <main>

            <a href="{{ route('records.create') }}">Add New</a>

            <div class="card">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Song</th>
                        <th>Artist</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($records as $record)
                        <tr>
                            <td>{{ $record->name }}</td>
                            <td>{{ $record->artist }}</td>
                            <td>
                                <a href="{{ route('records.show', $record->id) }}">Show</a>
                                <a href="{{ route('records.edit', $record->id) }}">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </main>
        <div class="spanner"></div>
    </div>
    <div class="vertical-spacer"></div>

@endsection