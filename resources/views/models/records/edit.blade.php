@extends('layouts.master')

@section('content')

    {{ Breadcrumbs::render('records.edit', $record) }}

    <main>

        <article class="container">

            <form action="{{ route('records.update', $record->id) }}" class="form" method="post">

                <header class="pl-3">
                    <h1>Update Song</h1>
                </header>

                {!! csrf_field() !!}
                {!! method_field('patch') !!}

                <section class="row">

                    <div class="input-field col s12 m6">
                        <input id="name" class="validate" type="text" name="name"
                               value="{{ $record->name }}">
                        <label for="name">Name</label>
                    </div>

                    <div class="input-field col s12 m6">
                        <input id="artist" class="validate" type="text" name="artist"
                               value="{{ $record->artist }}">
                        <label for="artist">Artist</label>
                    </div>

                    <div class="input-field col s12 m6">
                        <input id="youtube_id" class="validate" type="text" name="youtube_id"
                               value="{{ $record->youtube_id }}">
                        <label for="youtube_id">Youtube Video Id</label>
                    </div>

                    <div class="input-field col s12 m6">
                        <input id="video_start" class="validate" type="number" step="1" name="video_start"
                               value="{{ $record->video_start }}">
                        <label for="video_start">Video Start</label>
                    </div>

                    <div class="input-field col s12 m6">
                        <input id="video_end" class="validate" type="number" step="1" name="video_end"
                               value="{{ $record->video_end }}">
                        <label for="video_end">Video End</label>
                    </div>

                </section>

                <section class="row">
                    <div class="col s12">
                        <div class="flex">
                            <div class="input-field flex-2">
                                <textarea id="lyrics" class="materialize-textarea" type="text" name="lyrics"
                                          rows="15">{{ $record->lyrics }}</textarea>
                                <label for="lyrics">Lyrics</label>
                            </div>
                            <div class="flex-1">
                                <a class="btn btn-large btn-floating waves-effect waves-light right stick top-6"
                                   href="{{ route('records.lyrics.sync', $record->id) }}"><i
                                            class="material-icons">sync</i></a>

                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </section>

                <footer class="row">
                    <div class="input-field col s12">
                        <button type="submit" class="btn btn-large waves-effect waves-light right">Save
                            <i class="material-icons left">send</i></button>
                        <div class="clearfix"></div>
                    </div>
                </footer>

            </form>

        </article>
    </main>

@endsection