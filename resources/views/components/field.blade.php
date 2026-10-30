@props(['label', 'name', 'textarea' => false])

@php
    $id = "field-{$name}";
    $error = $errors->first($name);
    $classes = 'w-full rounded-2xl border bg-cream px-5 py-4 text-coffee placeholder:text-coffee/35 outline-none transition-all focus:border-olive focus:ring-4 focus:ring-olive/15 '.($error ? 'border-destructive' : 'border-input');
@endphp

<div>
    <label for="{{ $id }}" class="mb-2 block text-sm font-semibold text-coffee">
        {{ $label }}
    </label>
    @if ($textarea)
        <textarea id="{{ $id }}" name="{{ $name }}" rows="5" aria-invalid="{{ $error ? 'true' : 'false' }}" @if ($error) aria-describedby="{{ $id }}-error" @endif {{ $attributes->class([$classes, 'resize-none']) }}>{{ old($name) }}</textarea>
    @else
        <input id="{{ $id }}" name="{{ $name }}" value="{{ old($name) }}" aria-invalid="{{ $error ? 'true' : 'false' }}" @if ($error) aria-describedby="{{ $id }}-error" @endif {{ $attributes->class($classes)->merge(['type' => 'text']) }}>
    @endif
    <p id="{{ $id }}-error" class="mt-2 flex items-center gap-1.5 text-sm text-destructive" @unless ($error) hidden @endunless>
        <x-icon name="circle-alert" class="size-3.5" />
        <span data-field-error>{{ $error }}</span>
    </p>
</div>
