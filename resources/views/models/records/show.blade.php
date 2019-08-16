@extends('layouts.master')

@push('styles')
    <style>
        html, body {
            background-color: black;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .record-selector {
            position: fixed;
            bottom: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.4);
            color: white;
            background: rgba(250, 250, 250, 0.2);
            border-radius: 0.5em;
            padding: 1em;
            margin: 1em;
            display: flex;
            flex-direction: column;
            max-height: 10em;
            overflow-y: scroll;
        }

        .video-container {
            position: fixed;
            top: 0;
            right: 0;
            max-width: 50vw;
            height: auto;
        }

        .lyrics-container {
            background: rgba(250, 250, 250, 0.1);
            color: white;
            padding: 2em;
            line-height: 1em;
        }
    </style>
@endpush

@section('content')
    @if($record->video)
        <div class="video-container">
            {!! $record->video !!}
        </div>
    @endif

    <div class="record-selector">
        @foreach($available_records as $item)
            <div><a href="{{ route('records.show', $item->id) }}">{{ $item->name }}</a></div>
        @endforeach
    </div>

    <div class="container">
        <div class="row">

            <div class="col col-sm-12 col-lg-7">
                <div class="lyrics-container">
                    @if($record->lyrics)
                        @foreach( explode(PHP_EOL,$record->lyrics) as $line)
                            <p>{{ $line }}</p>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection