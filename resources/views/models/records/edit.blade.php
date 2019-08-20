@extends('layouts.master')

@section('content')

    {{ Breadcrumbs::render('records.edit', $record) }}

    <div class="vertical-spacer"></div>
    <div class="container">
        <div class="spanner"></div>
        <main>

            <div class="card">
                <div class="card-body">

                    <h1>Song Record Edit</h1>

                    <br>

                    <form action="{{ route('records.update', $record->id) }}" class="form" method="post">

                        {!! csrf_field() !!}
                        {!! method_field('patch') !!}

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" class="form-control" type="text" name="name"
                                   placeholder="Name of the song" value="{{ $record->name }}">
                        </div>

                        <div class="form-group">
                            <label for="artist">Artist</label>
                            <input id="artist" class="form-control" type="text" name="artist" placeholder="Artist"
                                   value="{{ $record->artist }}">
                        </div>

                        <div class="form-group">
                            <label for="youtube_id">Youtube Video Id</label>
                            <input id="youtube_id" class="form-control" type="text" name="youtube_id"
                                   placeholder="Youtube embed code" value="{{ $record->youtube_id }}">
                        </div>

                        <div class="form-group">
                            <label for="video_start">Video Start</label>
                            <input id="video_start" class="form-control" type="number" step="1" name="video_start"
                                   placeholder="Video start time in seconds" value="{{ $record->video_start }}">
                        </div>

                        <div class="form-group clearfix">
                            <label for="lyrics">Lyrics</label>
                            <textarea id="lyrics" class="form-control" type="text" name="lyrics"
                                      placeholder="Song lyrics"
                                      rows="15">{{ $record->lyrics }}</textarea>
                            <a class="btn btn-link float-right" href="{{ route('records.lyrics.sync', $record->id) }}">Sync</a>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary">
                        </div>

                    </form>
                </div>
            </div>
        </main>
        <div class="spanner"></div>
    </div>
    <div class="vertical-spacer"></div>
@endsection