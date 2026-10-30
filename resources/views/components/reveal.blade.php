@props(['as' => 'div', 'delay' => 0])

<{{ $as }} {{ $attributes->class('reveal')->merge(['style' => "--delay: {$delay}ms"]) }}>
    {{ $slot }}
</{{ $as }}>
