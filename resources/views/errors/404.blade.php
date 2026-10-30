@extends('errors.layout')

@section('code', '404')
@section('title', 'Bu fincan boş çıktı')
@section('message', 'Aradığınız sayfayı bulamadık. Taşınmış ya da hiç demlenmemiş olabilir.')

@section('visual')
    <svg viewBox="0 0 24 24" class="mt-10 size-16 rotate-180 text-coffee" aria-hidden="true">
        <path d="M4 9h13v3a6.5 6.5 0 0 1-13 0V9Z" fill="currentColor" />
        <path d="M17 10.5h1.5a2.5 2.5 0 0 1 0 5H16" fill="none" stroke="currentColor" stroke-width="1.6" />
    </svg>
@endsection
