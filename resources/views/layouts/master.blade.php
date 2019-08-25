<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    @section('styles')
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @stack('styles')
    @endsection

    @yield('styles')

</head>
<body>

<div class="body-content">
    @yield('content')
</div>

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
@endsection

@yield('scripts')

</body>
</html>
