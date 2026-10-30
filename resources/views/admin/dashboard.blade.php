@extends('admin.layouts.app')

@section('title', 'Panel')

@section('content')
    <dl class="grid gap-4 sm:grid-cols-3">
        @foreach (['Aktif ürün' => $activeProducts, 'Toplam mesaj' => $totalMessages, 'Okunmamış mesaj' => $unreadMessages] as $label => $value)
            <div class="rounded-2xl bg-card p-6 shadow-[0_1px_0_0_var(--border)]">
                <dt class="text-xs uppercase tracking-[0.2em] text-muted-foreground">{{ $label }}</dt>
                <dd class="mt-2 font-serif text-4xl text-coffee">{{ $value }}</dd>
            </div>
        @endforeach
    </dl>

    <section class="mt-10" aria-labelledby="latest-messages">
        <div class="mb-4 flex items-center justify-between gap-4">
            <h2 id="latest-messages" class="font-serif text-2xl text-coffee">Son mesajlar</h2>
            <a href="{{ route('admin.messages.index') }}" class="text-sm font-medium text-coffee underline decoration-olive/50 underline-offset-4 hover:decoration-olive">Tümünü gör</a>
        </div>

        <div class="space-y-3">
            @forelse ($latestMessages as $message)
                <x-admin.message-row :message="$message" />
            @empty
                <p class="text-muted-foreground">Henüz mesaj yok.</p>
            @endforelse
        </div>
    </section>
@endsection
