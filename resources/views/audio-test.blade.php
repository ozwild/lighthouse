@extends('layouts.master')

@section('content')

    <form action="/audio-test" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <input type="file" name="audio_file" accept=".mp3,.ogg">
        <button type="submit">Submit</button>
    </form>

    <audio controls style="width: 100%;">
        <source src="{{ route('get-audio', 'Dark Necessities.mp3') }}" >
    </audio>

@endsection