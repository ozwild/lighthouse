@extends('layouts.master')

@push('scripts')
    <script>

        const app = new apps.LyricsSyncApp(@json($record));

    </script>
@endpush

@section('content')

    {{ Breadcrumbs::render('lyrics.sync', $record) }}

    <main>
        <section>

            <h1>Lyrics Sync</h1>

            <div class="row">
                <div class="col s12">
                    <div class="flex">
                        <div class="flex-2">
                            <div class="lyrics-container sync"></div>
                        </div>
                        <div class="flex-1">
                            <button class="save-lyrics btn btn-floating waves-effect waves-light right stick top-6"
                                    onclick="save('{{ route('records.update', $record->id) }}')">
                                <i class="material-icons">save</i></button>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </main>

    @if($record->youtube_id)
        @include('components.video.source')
        @include('components.video.controls')
    @endif

@endsection