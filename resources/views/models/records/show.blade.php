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
            color: white;
            background: rgba(250, 250, 250, 0.2);
            border-radius: 0.5em;
            padding: 1em;
            margin: 1em;
            display: flex;
            flex-direction: column;
            max-height: 10em;
            overflow-y: scroll;
            z-index: 1;
        }

        .video-container {
            position: fixed;
            top: 0;
            right: 0;
            max-width: 50vw;
            height: auto;
            z-index: 1;
        }

        .lyrics-container {
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            transition: top 0.3s;
            z-index: 1;
            pointer-events: none;
        }

        .lyrics-container .lyrics-block.active {
            padding: 2em 0;
        }

        .lyrics-container p {
            color: #444;
            line-height: 1;
            font-size: 2em;
            font-weight: 500;
            transition: color 0.3s, transform 0.3s;
            transform: scale(0.85);
        }

        .lyrics-container p.active,
        .lyrics-container .active p {
            color: yellowgreen;
            transform: scale(1);
        }

    </style>
@endpush

@push('scripts')
    <script>
        const app = window.app;
        const recordModel = @json($record);
        const VideoController = app.controllers.VideoController;
        const LyricsController = app.controllers.LyricsDisplayController;

        app.YTAPILoader.load().then(() => {
            VideoController.load(recordModel, 'player');
            LyricsController.load(recordModel, '.lyrics-container');

            VideoController.app.on('tick', timestamp => {
                LyricsController.app.showLyricsForTime(timestamp);
            });

        });

    </script>
@endpush

@section('content')

    {{ Breadcrumbs::render('records.show', $record) }}

    @if($record->youtube_id)
        <div class="video-timer"></div>
        <div class="video-container">
            <div id="player"></div>
        </div>
    @endif

    <div class="record-selector">
        @foreach($available_records as $item)
            <div><a href="{{ route('records.show', $item->id) }}">{{ $item->name }}</a></div>
        @endforeach
    </div>

    <div class="lyrics-container col col-sm-12 col-md-8"></div>

@endsection