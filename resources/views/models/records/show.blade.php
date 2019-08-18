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
            background: rgba(250, 250, 250, 0.1);
            color: white;
            padding: 2em;
            line-height: 1em;
            z-index: 1;
            position: fixed;
            pointer-events: none;
        }

        .lyrics-container p {
            line-height: 0.75em;
            font-size: 1.5em;
        }

        .lyrics-container p.active,
        .lyrics-container .active p {
            color: yellow;
            font-weight: 500;
            font-size: 1.75em;
            /* line-height: 1.5em; */
            padding: 0 1em;
        }

    </style>
@endpush

@include('components.youtube')

@push('scripts')
    <script>

        (function () {

            let timeRegularExpression = /(?:\[)([\d.]+)(?:\])/;

            let record = @json($record);

            function createLine(content) {

                let timestamp, timestampMatch, $element, lyricsText;

                $element = $("<p>", {
                    class: "lyrics-line"
                });

                lyricsText = content.replace(timeRegularExpression, "").trim();

                $element.html(lyricsText);

                timestampMatch = content.match(timeRegularExpression);

                if (timestampMatch) {
                    timestamp = timestampMatch[1];
                    $element.attr('data-timestamp', timestamp);
                }

                return $element;

            }

            function createBlock(content) {
                return $("<div>", {
                    class: "lyrics-block"
                }).html(content);
            }

            function processLyrics() {

                let $container = $(".lyrics-container");
                let lyricsText = record.lyrics;
                let groupSplits, $blocks;

                /**
                 * Get Blocks
                 */

                lyricsText = lyricsText.replace(/[\r\n]\s{2,}/g, '[break here]');
                groupSplits = lyricsText.split('[break here]');

                $blocks = groupSplits.map(function (textBlock) {

                    let lineSplits = textBlock.split("\n");
                    let $blockLines = lineSplits.map(textLine => createLine(textLine));

                    return createBlock($blockLines);

                });

                $container.html($blocks);

                return $blocks;

            }

            processLyrics();

        })();

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