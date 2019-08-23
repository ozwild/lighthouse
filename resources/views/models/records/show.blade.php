@extends('layouts.master')

@push('styles')
    <style>

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
            overflow-y: auto;
            z-index: 4;
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
        <div class="player-container">
            <div id="player"></div>
        </div>
    @endif

    <div class="record-selector">
        @foreach($available_records as $item)
            <div><a href="{{ route('records.show', $item->id) }}">{{ $item->name }}</a></div>
        @endforeach
    </div>

    <div class="lyrics-container display"></div>

@endsection