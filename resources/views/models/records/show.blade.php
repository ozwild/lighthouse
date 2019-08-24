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

        const app = new apps.LyricsDisplayApp(@json($record));

    </script>
@endpush

@section('content')

    {{ Breadcrumbs::render('records.show', $record) }}

    @include('components.video.source')

    <div class="lyrics-container display"></div>

@endsection