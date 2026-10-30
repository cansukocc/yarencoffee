@extends('layouts.app')

@section('content')
    <a href="#main" class="sr-only z-[80] rounded-full bg-coffee px-5 py-3 text-sm font-semibold text-cream focus:not-sr-only focus:fixed focus:left-4 focus:top-4">Ana içeriğe atla</a>
    <div aria-hidden="true" class="fixed inset-x-0 top-0 z-[70] h-0.5 origin-left scale-x-0 bg-olive" data-scroll-progress></div>

    @include('sections.header')

    <main id="main" tabindex="-1" class="outline-none">
        @include('sections.hero')
        @include('sections.story')
        @include('sections.products')
        @include('sections.timeline')
        @include('sections.fortune')
        @include('sections.contact')
    </main>

    @include('sections.footer')
@endsection
