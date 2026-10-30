@props(['href' => null, 'variant' => 'primary'])

@php
    $classes = [
        'inline-flex items-center justify-center gap-2 rounded-full px-5 py-2.5 text-sm font-semibold transition-colors',
        'bg-coffee text-cream hover:bg-olive' => $variant === 'primary',
        'border border-coffee/20 text-coffee hover:border-coffee' => $variant === 'secondary',
        'border border-destructive/30 text-destructive hover:bg-destructive hover:text-cream' => $variant === 'danger',
    ];
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->class($classes)->merge(['type' => 'submit']) }}>{{ $slot }}</button>
@endif
