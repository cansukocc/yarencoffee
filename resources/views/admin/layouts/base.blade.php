<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex">
        <meta name="color-scheme" content="light">
        <title>@yield('title') — Yâren Yönetim</title>
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
        @vite(['resources/css/app.css', 'resources/js/admin.js'])
    </head>
    <body class="min-h-screen bg-background antialiased">
        @yield('body')
    </body>
</html>
