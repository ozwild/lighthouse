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
            color: white;
            line-height: 1;
            position: fixed;
            pointer-events: none;
            z-index: 1;
            text-align: center;
            top: 0;
            transition: top 0.3s;
        }

        .lyrics-container .lyrics-block.active {
            padding: 2em 0;
        }

        .lyrics-container p {
            color: rgba(255, 255, 0, 0.2);
            line-height: 1;
            font-size: 1.5em;
            transition: color;
        }

        .lyrics-container p.active,
        .lyrics-container .active p {
            color: rgba(255, 255, 0, 1);
            font-weight: 500;
            font-size: 1.75em;
            line-height: 1.15;
        }

    </style>
@endpush

@include('assets.youtube')
@include('assets.video')
@include('assets.lyrics')

@push('scripts')
    <script>

        const recordModel = @json($record);
        let videoHelper;
        let lyricsHelper;
        let isPlaying = false;

        document.addEventListener('youtube.ready', () => {
            videoHelper = new VideoHelper();
            videoHelper.recordModel = recordModel;
            videoHelper.initialize();
            videoHelper.on('playing', (...arguments) => {
                isPlaying = true;
            });
            videoHelper.on('stopped', (...arguments) => {
                isPlaying = false;
            });
            videoHelper.on('tick', time => {
                lyricsHelper.showElementForTime(time);
            });
        });

        $(document).ready(() => {
            lyricsHelper = new LyricsHelper('.lyrics-container');
            lyricsHelper.recordModel = recordModel;
            lyricsHelper.process();
            lyricsHelper.render();
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

    <div class="container">
        <div class="row">

            <div class="col col-sm-12 col-lg-7">
                <div class="lyrics-container">
                    {{ $record->lyrics }}
                </div>
            </div>

        </div>
    </div>
@endsection