<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    @section('styles')
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
            html, body{
                background-color: #333;
            }
            .container {
                display: flex;
            }

            .container > * {
                flex: 2;
            }

            .container main {
                flex: 5 auto;
            }

            .vertical-spacer {
                height: 3em;
            }
        </style>
        @stack('styles')
    @endsection

    @yield('styles')

</head>
<body>

@yield('content')

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
@endsection

@yield('scripts')

</body>
</html>
