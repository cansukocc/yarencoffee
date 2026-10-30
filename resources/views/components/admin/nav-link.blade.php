@props(['route', 'active'])

<a
    href="{{ route($route) }}"
    @class([
        'flex items-center justify-between rounded-xl px-4 py-2.5 text-sm font-medium transition-colors',
        'bg-cream/15 text-cream' => request()->routeIs($active),
        'text-cream/75 hover:bg-cream/10 hover:text-cream' => ! request()->routeIs($active),
    ])
    @if (request()->routeIs($active)) aria-current="page" @endif
>
    {{ $slot }}
</a>
