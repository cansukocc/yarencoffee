@extends('admin.layouts.app')

@section('title', 'Site Ayarları')

@section('content')
    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-5 rounded-[2rem] bg-card p-6 md:p-8">
        @csrf
        @method('PUT')

        <x-admin.field label="Slogan" name="slogan" :value="$settings['slogan'] ?? ''" maxlength="255" required />
        <x-admin.field label="Giriş metni" name="hero_subtitle" :value="$settings['hero_subtitle'] ?? ''" maxlength="500" textarea required />
        <x-admin.field label="Rozet" name="hero_badge" :value="$settings['hero_badge'] ?? ''" maxlength="120" required />
        <x-admin.field label="Adres" name="contact_address" :value="$settings['contact_address'] ?? ''" maxlength="255" required />

        <div class="grid gap-5 md:grid-cols-2">
            <x-admin.field label="E-posta" name="contact_email" type="email" :value="$settings['contact_email'] ?? ''" maxlength="200" required />
            <x-admin.field label="Telefon" name="contact_phone" :value="$settings['contact_phone'] ?? ''" maxlength="60" required />
        </div>

        <section class="space-y-5 border-t border-border pt-6" aria-labelledby="seo-title">
            <h2 id="seo-title" class="font-serif text-2xl text-coffee">SEO</h2>

            <div>
                <x-admin.field label="Sayfa başlığı" name="meta_title" :value="$settings['meta_title'] ?? ''" maxlength="60" required />
                <p class="mt-2 text-xs text-muted-foreground" data-char-counter="field-meta_title"></p>
            </div>

            <div>
                <x-admin.field label="Sayfa açıklaması" name="meta_description" :value="$settings['meta_description'] ?? ''" maxlength="160" textarea required />
                <p class="mt-2 text-xs text-muted-foreground" data-char-counter="field-meta_description"></p>
            </div>
        </section>

        <x-admin.button>Kaydet</x-admin.button>
    </form>
@endsection
