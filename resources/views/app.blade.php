@extends('layouts.master')

@section('content')
    @if($loadedRecord)
        <div class="video-container">
            {!! $loadedRecord->video !!}
        </div>
    @endif

    <div class="record-selector">
        @foreach($records as $record)
            <div><a href="{{ route('home', ["record"=>$record->id]) }}">{{ $record->name }}</a></div>
        @endforeach
    </div>

    <div class="container">
        <div class="row">

            <div class="col col-sm-12 col-lg-7">
                <div class="lyrics-container">
                    @if($loadedRecord)
                        @foreach( explode(PHP_EOL,$loadedRecord->lyrics) as $line)
                            <p>{{ $line }}</p>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection