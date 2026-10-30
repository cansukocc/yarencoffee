@props(['label', 'name', 'value' => null, 'textarea' => false])

@php
    $id = "field-{$name}";
    $error = $errors->first($name);
    $classes = 'w-full rounded-xl border bg-card px-4 py-3 text-coffee outline-none transition-colors focus:border-olive focus:ring-4 focus:ring-olive/15 '.($error ? 'border-destructive' : 'border-input');
@endphp

<div>
    <label for="{{ $id }}" class="mb-2 block text-sm font-semibold text-coffee">{{ $label }}</label>
    @if ($textarea)
        <textarea id="{{ $id }}" name="{{ $name }}" rows="4" aria-invalid="{{ $error ? 'true' : 'false' }}" @if ($error) aria-describedby="{{ $id }}-error" @endif {{ $attributes->class([$classes, 'resize-y']) }}>{{ old($name, $value) }}</textarea>
    @else
        <input id="{{ $id }}" name="{{ $name }}" value="{{ old($name, $value) }}" aria-invalid="{{ $error ? 'true' : 'false' }}" @if ($error) aria-describedby="{{ $id }}-error" @endif {{ $attributes->class($classes)->merge(['type' => 'text']) }}>
    @endif
    <x-admin.field-error :id="$id.'-error'" :message="$error" />
</div>
