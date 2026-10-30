<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex">
        <meta name="theme-color" content="#F5F0E6">
        <meta name="color-scheme" content="light">
        <title>@yield('title') — Yâren</title>
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
        @vite('resources/css/app.css')
    </head>
    <body class="bg-background antialiased">
        <main class="mx-auto flex min-h-screen max-w-xl flex-col items-start justify-center px-5 py-16">
            <a href="{{ url('/') }}" class="text-3xl text-coffee" aria-label="Yâren ana sayfa">
                <x-logo />
            </a>

            @yield('visual')

            <p class="mt-8 text-xs font-semibold uppercase tracking-[0.25em] text-olive-ink">Hata @yield('code')</p>
            <h1 class="mt-4 font-serif text-5xl leading-tight text-coffee md:text-6xl">@yield('title')</h1>
            <p class="mt-5 max-w-md leading-relaxed text-coffee/75">@yield('message')</p>

            <a href="{{ url('/') }}" class="mt-9 inline-flex items-center gap-3 rounded-full bg-olive px-7 py-3.5 text-sm font-semibold text-cream transition-colors hover:bg-coffee">
                Ana sayfaya dön
            </a>
        </main>
    </body>
</html>
