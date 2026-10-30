@props(['label', 'name', 'textarea' => false])

@php
    $id = "field-{$name}";
    $classes = 'w-full rounded-2xl border border-input bg-cream px-5 py-4 text-coffee placeholder:text-coffee/35 outline-none transition-all focus:border-olive focus:ring-4 focus:ring-olive/15';
@endphp

<div>
    <label for="{{ $id }}" class="mb-2 block text-sm font-semibold text-coffee">
        {{ $label }}
    </label>
    @if ($textarea)
        <textarea id="{{ $id }}" name="{{ $name }}" rows="5" aria-invalid="false" {{ $attributes->class([$classes, 'resize-none']) }}></textarea>
    @else
        <input id="{{ $id }}" name="{{ $name }}" aria-invalid="false" {{ $attributes->class($classes)->merge(['type' => 'text']) }}>
    @endif
    <p id="{{ $id }}-error" class="mt-2 flex items-center gap-1.5 text-sm text-destructive" hidden>
        <x-icon name="circle-alert" class="size-3.5" />
        <span data-field-error></span>
    </p>
</div>
