<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Yâren — {{ rtrim($settings['slogan'], '.') }}</title>
        <meta name="description" content="Yâren, geleneksel Türk kahvesini espresso ve modern demleme kültürüyle buluşturan bir kahve markası.">
        <meta name="theme-color" content="#F5F0E6">
        <meta name="color-scheme" content="light">
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
        <script>document.documentElement.classList.add('js')</script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="grain antialiased bg-background">
        @yield('content')
    </body>
</html>
