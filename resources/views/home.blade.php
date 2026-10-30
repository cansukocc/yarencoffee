@extends('layouts.app')

@section('content')
    <main class="mx-auto flex max-w-3xl flex-col items-start gap-8 px-6 py-16">
        <x-logo class="text-3xl text-coffee" />

        <h1 class="font-serif text-8xl font-light tracking-tight text-coffee animate-in fade-in slide-in-from-bottom-6 duration-1000 fill-mode-both">Yâren</h1>
        <p class="font-serif text-3xl italic text-coffee">Her fincanda ortak bir hikâye.</p>
        <p class="text-xl text-muted-foreground">ğüşıİçöâ</p>
        <p class="font-serif text-xl italic text-olive">ğüşıİçöâ</p>

        <div class="flex gap-4 text-olive">
            <x-icon name="sparkles" class="size-6" />
            <x-icon name="map-pin" class="size-6" />
            <x-icon name="circle-check" class="size-6" />
        </div>

        <img src="{{ asset('images/hero-cup.webp') }}" alt="Ahşap masa üzerinde bir fincan kahve" width="1400" height="764" class="float-slow w-full rounded-3xl">

        <x-reveal class="w-full rounded-3xl bg-card p-8 text-card-foreground" :delay="150">
            Bu kutu kaydırınca görünür.
        </x-reveal>
    </main>
@endsection
