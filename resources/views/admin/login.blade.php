@extends('admin.layouts.base')

@section('title', 'Giriş')

@section('body')
    <main class="flex min-h-screen items-center justify-center px-5 py-10">
        <div class="w-full max-w-md rounded-[2rem] bg-card p-8 shadow-[0_30px_60px_-40px_rgba(59,36,24,0.5)] md:p-10">
            <x-logo class="text-3xl text-coffee" />
            <h1 class="mt-6 font-serif text-3xl text-coffee">Yönetim paneli</h1>

            <form method="POST" action="{{ route('admin.login.store') }}" class="mt-8 space-y-5">
                @csrf
                <x-admin.field label="E-posta" name="email" type="email" autocomplete="username" required autofocus />
                <div>
                    <label for="field-password" class="mb-2 block text-sm font-semibold text-coffee">Şifre</label>
                    <input id="field-password" name="password" type="password" autocomplete="current-password" required class="w-full rounded-xl border border-input bg-card px-4 py-3 text-coffee outline-none transition-colors focus:border-olive focus:ring-4 focus:ring-olive/15">
                </div>
                <x-admin.button class="w-full">Giriş Yap</x-admin.button>
            </form>
        </div>
    </main>
@endsection
