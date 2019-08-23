@extends('layouts.master')

@section('content')

    {{ Breadcrumbs::render('records.index') }}

    <br>

    <main>

        <div class="container">

            <a class="btn btn-floating waves-ripple waves-light light-green appears right"
               href="{{ route('records.create') }}"><i
                        class="material-icons right">add</i></a>

            <div class="clearfix"></div>

            <br>

            <ul class="record-list">

                @foreach($records as $record)

                    <li>

                        <a href="{{ route('records.show', $record->id) }}" class="link play-link">
                            <i class="material-icons tiny default-icon">audiotrack</i>
                            <i class="material-icons tiny hover-icon">play_arrow</i>
                        </a>

                        <a href="{{ route('records.edit', $record->id) }}" class="link edit-link">
                            <i class="material-icons tiny">edit</i>
                        </a>

                        <div>
                            <div>{{ $record->name }}</div>
                            <div class="secondary-line"><a href="#">{{ $record->artist }}</a></div>
                        </div>

                    </li>

                @endforeach

            </ul>

        </div>
    </main>

@endsection