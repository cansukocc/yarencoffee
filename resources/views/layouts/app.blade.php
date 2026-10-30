<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $settings['meta_title'] }}</title>
        <meta name="description" content="{{ $settings['meta_description'] }}">
        <link rel="canonical" href="{{ url('/') }}/">
        <meta property="og:type" content="website">
        <meta property="og:locale" content="tr_TR">
        <meta property="og:site_name" content="Yâren">
        <meta property="og:title" content="{{ $settings['meta_title'] }}">
        <meta property="og:description" content="{{ $settings['meta_description'] }}">
        <meta property="og:url" content="{{ url('/') }}/">
        <meta property="og:image" content="{{ asset('images/og-cover.jpg') }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:alt" content="Ahşap masada Türk kahvesi fincanı ve Yâren logosu">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $settings['meta_title'] }}">
        <meta name="twitter:description" content="{{ $settings['meta_description'] }}">
        <meta name="twitter:image" content="{{ asset('images/og-cover.jpg') }}">
        <meta name="theme-color" content="#F5F0E6">
        <meta name="color-scheme" content="light">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
        <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="preload" as="image" href="{{ asset('images/hero-cup.webp') }}" fetchpriority="high">
        <link rel="preload" as="font" type="font/woff2" href="{{ Vite::asset('node_modules/@fontsource-variable/fraunces/files/fraunces-latin-wght-normal.woff2') }}" crossorigin>
        <script>
            (function (root) {
                root.classList.add('js');
                setTimeout(function () {
                    if (!window.yarenReady) {
                        root.classList.remove('js');
                    }
                }, 3000);
            })(document.documentElement);
        </script>
        <script type="application/ld+json">{!! $structuredData !!}</script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="grain antialiased bg-background">
        @yield('content')
    </body>
</html>
