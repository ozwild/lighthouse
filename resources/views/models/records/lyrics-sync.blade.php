@extends('layouts.master')

@push('styles')
    <style>
        html, body {
            background-color: #EC5746;
            /*background-color: black;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;*/
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
            color: #353535;
        }

        .lyrics-container .lyrics-block.active {
            padding: 2em 0;
        }

        .lyrics-container .lyrics-line {
            display: flex;
            align-items: baseline;
            cursor: pointer;
        }

        .lyrics-container .selected {
            color: white;
            animation: lineSelection 600ms alternate infinite;
        }

        .lyrics-container .lyrics-line .timestamp {
            padding: 2px 3px;
            line-height: 1;
            font-size: 0.9em;
            border-bottom: 2px solid transparent;
            margin-bottom: 6px;
        }

        .lyrics-container .lyrics-line .timestamp.active {
            color: white;
            animation: timestampSelection 600ms alternate infinite;
        }

        .lyrics-container .lyrics-line .lyric-content {
            font-weight: 500;
        }

        .lyrics-container .lyrics-line .lyric-start {
            margin-left: 8px;
            color: brown;
        }

        .lyrics-container .lyrics-line .lyric-end {
            margin-right: 8px;
            color: brown;
        }

        @keyframes lineSelection {
            0% {
                border-bottom: 1px solid rgba(250, 250, 250, 0);
            }
            100% {
                border-bottom: 1px solid rgba(250, 250, 250, 0.75);
            }
        }

        @keyframes timestampSelection {
            0% {
                border-color: rgba(250, 250, 250, 0);
            }
            100% {
                border-color: rgba(250, 250, 250, 0.75);
            }
        }

    </style>
@endpush

@push('scripts')
    <script>
        const app = window.app;
        const recordModel = @json($record);
        const VideoController = app.controllers.VideoController;
        const LyricsController = app.controllers.LyricsSyncController;

        app.YTAPILoader.load().then(() => {
            VideoController.load(recordModel, 'player');
            LyricsController.load(recordModel, '.lyrics-container');
            LyricsController.pairVideoController(VideoController);
        });

    </script>
@endpush

@section('content')

    {{ Breadcrumbs::render('lyrics.sync', $record) }}

    <h1>Lyrics Synchronization</h1>

    <div class="p-1">
        <button class="btn btn-outline-light" onclick="play()"><i class="fa fa-save"></i> Play</button>
        <button class="btn btn-outline-light" onclick="pause()"><i class="fa fa-save"></i> Pause</button>
        <button class="btn btn-outline-light" onclick="stop()"><i class="fa fa-save"></i> Stop</button>
        <button class="btn btn-outline-light" onclick="next()"><i class="fa fa-save"></i> Next Line</button>
        <button class="btn btn-outline-light" onclick="saveChanges()"><i class="fa fa-save"></i> Save Changes</button>
    </div>

    <div class="lyrics-container"></div>

    <div class="video-container">
        <div id="player"></div>
    </div>

@endsection