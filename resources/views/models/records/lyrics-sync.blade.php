@extends('layouts.master')

@push('scripts')
    <script>

        apps.LyricsSyncApp.load('#lyrics-sync-container');
        const app = new apps.LyricsSyncApp(@json($record));

    </script>
@endpush

@section('content')

    {{ Breadcrumbs::render('lyrics.sync', $record) }}

    <main>
        <section>
            <header class="pl-3">
                <h1>
                    {{ $record->name }}
                    @if($record->artist)
                        <br>
                        &gt;<span class="cyan-text text-darken-1">{{ $record->artist }} </span>&lt;
                    @endif
                </h1>
            </header>

            <div class="row">
                <div class="col s12">
                    <div class="flex">
                        <div id="lyrics-sync-container" class="flex-2">

                        </div>
                        <div class="flex-1">
                            <button class="save-lyrics btn btn-floating waves-effect waves-light right stick top-6"
                                    onclick="app.save('{{ route('records.update', $record->id) }}')">
                                <i class="material-icons">save</i></button>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </main>

@endsection