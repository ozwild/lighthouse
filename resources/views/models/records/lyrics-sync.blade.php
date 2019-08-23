@extends('layouts.master')

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

        function save() {
            if (!LyricsController.app) {
                return M.toast('No lyrics controller found');
            }

            let lyrics = LyricsController.app.toString();

            $.ajax('{{ route('records.update', $record->id) }}', {
                method: 'patch',
                data: {
                    lyrics
                },
                dataType: 'json',
            }).done(e => {
                M.toast("Lyrics saved!")
            }).fail(e => {
                M.toast("Something went wrong")
            });

        }

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
                                    onclick="save()">
                                <i class="material-icons">save</i></button>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </main>

    <div class="player-container">
        <div id="player"></div>
    </div>

@endsection