@props(['message'])

<a
    href="{{ route('admin.messages.show', $message) }}"
    @class([
        'block rounded-2xl border p-4 transition-colors hover:border-olive',
        'border-olive/40 bg-card' => ! $message->isRead(),
        'border-border bg-card/50' => $message->isRead(),
    ])
    data-message-row
>
    <div class="flex flex-wrap items-center justify-between gap-x-4 gap-y-1">
        <p @class(['flex min-w-0 items-center gap-2 text-coffee', 'font-semibold' => ! $message->isRead()])>
            @unless ($message->isRead())
                <span class="size-2 shrink-0 rounded-full bg-olive"></span>
                <span class="sr-only">Okunmadı:</span>
            @endunless
            <span class="truncate">{{ $message->name }}</span>
        </p>
        <time class="text-xs text-muted-foreground" datetime="{{ $message->created_at->toIso8601String() }}">{{ $message->created_at->format('d.m.Y H:i') }}</time>
    </div>
    <p class="mt-1 truncate text-sm text-muted-foreground">{{ $message->message }}</p>
</a>
