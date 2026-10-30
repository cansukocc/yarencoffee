@extends('layouts.app')

@section('content')
    @include('sections.header')

    <main>
        @include('sections.hero')
        @include('sections.story')
        @include('sections.products')
        @include('sections.timeline')
        @include('sections.fortune')
        @include('sections.contact')
    </main>

    @include('sections.footer')
@endsection
