@props(['id', 'message'])

@if ($message)
    <p id="{{ $id }}" class="mt-2 flex items-center gap-1.5 text-sm text-destructive">
        <x-icon name="circle-alert" class="size-3.5 shrink-0" />
        {{ $message }}
    </p>
@endif
