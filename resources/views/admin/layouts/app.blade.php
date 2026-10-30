@extends('admin.layouts.base')

@section('body')
    <div class="md:flex">
        <aside class="bg-coffee text-cream md:fixed md:inset-y-0 md:left-0 md:flex md:w-64 md:flex-col">
            <div class="flex h-18 items-center justify-between px-6">
                <a href="{{ route('admin.dashboard') }}" class="text-2xl" aria-label="Yönetim paneli ana sayfa">
                    <x-logo />
                </a>
                <button
                    type="button"
                    class="inline-flex size-11 items-center justify-center rounded-full border border-cream/20 md:hidden"
                    aria-expanded="false"
                    aria-controls="admin-menu"
                    aria-label="Menüyü aç"
                    data-admin-menu-toggle
                >
                    <x-icon name="menu" class="size-5" />
                </button>
            </div>

            <nav id="admin-menu" aria-label="Yönetim menüsü" class="hidden px-3 pb-6 md:flex md:flex-1 md:flex-col md:pb-6" data-admin-menu>
                <ul class="space-y-1">
                    <li><x-admin.nav-link route="admin.dashboard" active="admin.dashboard">Panel</x-admin.nav-link></li>
                    <li><x-admin.nav-link route="admin.products.index" active="admin.products.*">Ürünler</x-admin.nav-link></li>
                    <li><x-admin.nav-link route="admin.settings.edit" active="admin.settings.*">Site Ayarları</x-admin.nav-link></li>
                    <li>
                        <x-admin.nav-link route="admin.messages.index" active="admin.messages.*">
                            Mesajlar
                            @if ($unreadCount > 0)
                                <span class="rounded-full bg-olive px-2 py-0.5 text-xs font-semibold text-cream" data-unread-badge>{{ $unreadCount }}</span>
                            @endif
                        </x-admin.nav-link>
                    </li>
                </ul>

                <div class="mt-6 space-y-1 border-t border-cream/15 pt-4 md:mt-auto">
                    <a href="{{ url('/') }}" class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm text-cream/75 transition-colors hover:bg-cream/10 hover:text-cream">
                        Siteyi Gör
                        <x-icon name="arrow-up-right" class="size-4" />
                    </a>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="w-full rounded-xl px-4 py-2.5 text-left text-sm text-cream/75 transition-colors hover:bg-cream/10 hover:text-cream">
                            Çıkış
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <main class="min-w-0 flex-1 px-5 py-8 md:ml-64 md:px-10 md:py-10">
            <div class="mx-auto max-w-5xl">
                <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
                    <h1 class="font-serif text-4xl text-coffee">@yield('title')</h1>
                    @yield('actions')
                </div>

                @if (session('status'))
                    <div role="status" class="mb-6 flex items-center gap-3 rounded-2xl border border-olive/30 bg-olive/10 p-4 text-sm font-medium text-coffee">
                        <x-icon name="circle-check" class="size-4 shrink-0 text-olive" />
                        {{ session('status') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
@endsection
