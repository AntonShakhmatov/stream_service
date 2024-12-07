<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- @if(app()->isProduction())--}}
    {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">--}}
    {{-- @endif--}}

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->

    <!-- Scripts -->
    @routes

    @if (Request::is('/'))
    @vite(['src/main.js', 'src/assets/css/main.css'], 'build') <!-- Подключаю скрипт для маршрута home -->
    @else
    @vite(['src/index.ts', 'src/assets/css/main.css'], 'build') <!-- Подключаю другой скрипт для остальных маршрутов -->
    @endif

    @inertiaHead
</head>

<body class="h-full">
    @inertia
</body>

</html>