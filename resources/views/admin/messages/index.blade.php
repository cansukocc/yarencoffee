@extends('admin.layouts.app')

@section('title', 'Mesajlar')

@section('actions')
    <div class="flex gap-2" role="group" aria-label="Mesaj filtresi">
        <x-admin.button :variant="$unreadOnly ? 'secondary' : 'primary'" :href="route('admin.messages.index')">Tümü</x-admin.button>
        <x-admin.button :variant="$unreadOnly ? 'primary' : 'secondary'" :href="route('admin.messages.index', ['filtre' => 'okunmamis'])">Okunmamış</x-admin.button>
    </div>
@endsection

@section('content')
    <div class="space-y-3">
        @forelse ($messages as $message)
            <x-admin.message-row :message="$message" />
        @empty
            <p class="text-muted-foreground">{{ $unreadOnly ? 'Okunmamış mesaj yok.' : 'Henüz mesaj yok.' }}</p>
        @endforelse
    </div>

    {{ $messages->links('admin.partials.pagination') }}
@endsection
