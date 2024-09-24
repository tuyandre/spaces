<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>        <!--end::Fonts-->

    <!-- Scripts -->
    @vite(['resources/sass/app.scss','resources/sass/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <main class="py-4 d-flex min-vh-100 flex-column justify-content-center">
            @yield('content')
        </main>
    </div>
</body>
</html>
