@extends('layouts.master')

@section('content')
    <div class="vertical-spacer"></div>
    <div class="container">
        <div class="spanner"></div>
        <main>
            <div class="card">
                <div class="card-body">

                    <h1>Create new song record</h1>

                    <br>

                    <form action="{{ route('records.store') }}" class="form" method="post">

                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" class="form-control" type="text" name="name" placeholder="Name of the song">
                        </div>

                        <div class="form-group">
                            <label for="artist">Artist</label>
                            <input id="artist" class="form-control" type="text" name="artist" placeholder="Artist">
                        </div>

                        <div class="form-group">
                            <label for="video">Video</label>
                            <textarea id="video" class="form-control" type="text" name="video" placeholder="Youtube embed code"
                                      rows="5"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="lyrics">Lyrics</label>
                            <textarea id="lyrics" class="form-control" type="text" name="lyrics" placeholder="Song lyrics"
                                      rows="15"></textarea>
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