@extends('admin.layouts.app')

@section('title', 'Mesaj')

@section('content')
    <article class="rounded-[2rem] bg-card p-6 md:p-8">
        <dl class="grid gap-4 sm:grid-cols-3">
            <div class="min-w-0">
                <dt class="text-xs uppercase tracking-[0.2em] text-muted-foreground">Ad</dt>
                <dd class="mt-1 break-words text-coffee">{{ $message->name }}</dd>
            </div>
            <div class="min-w-0">
                <dt class="text-xs uppercase tracking-[0.2em] text-muted-foreground">E-posta</dt>
                <dd class="mt-1 break-words text-coffee">{{ $message->email }}</dd>
            </div>
            <div class="min-w-0">
                <dt class="text-xs uppercase tracking-[0.2em] text-muted-foreground">Tarih</dt>
                <dd class="mt-1 text-coffee">{{ $message->created_at->format('d.m.Y H:i') }}</dd>
            </div>
        </dl>

        <p class="mt-8 whitespace-pre-line break-words leading-relaxed text-coffee" data-message-body>{{ $message->message }}</p>

        <div class="mt-8 flex flex-wrap gap-3 border-t border-border pt-6">
            <x-admin.button :href="'mailto:'.$message->email.'?subject='.rawurlencode('Yâren iletişim mesajınız')">Yanıtla</x-admin.button>
            <form method="POST" action="{{ route('admin.messages.unread', $message) }}">
                @csrf
                @method('PATCH')
                <x-admin.button variant="secondary">Okunmadı Yap</x-admin.button>
            </form>
            <x-admin.delete-form :action="route('admin.messages.destroy', $message)" confirm="Bu mesaj silinsin mi?" />
        </div>
    </article>

    <a href="{{ route('admin.messages.index') }}" class="mt-6 inline-block text-sm font-medium text-coffee underline decoration-olive/50 underline-offset-4 hover:decoration-olive">Mesajlara dön</a>
@endsection
