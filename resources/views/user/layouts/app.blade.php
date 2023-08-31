<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ URL::asset('resources/uploads/logo/fav.png')}}" />
    <title>{{ config('app.name', 'Hive Inspection') }}</title>
    @include('user.layouts.Css')
    @yield('css')
</head>
<body>


    <div id="app">
        <main>
            @if (Auth::check())
                @include('user.layouts.header')
            @endif
            @yield('content')
            @include('user.layouts.footer')
        </main>
    </div>
    <script src="{{ URL::asset('public/js/app.js') }}"></script>
    @include('user.layouts.Js')
    @yield('script')
</body>
</html>