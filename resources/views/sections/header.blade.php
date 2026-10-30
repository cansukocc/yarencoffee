<header class="sticky top-0 z-50" data-header>
    <div class="absolute inset-0 -z-10 transition-all duration-500" data-header-background></div>

    <nav aria-label="Ana menü" class="mx-auto flex h-18 max-w-7xl items-center justify-between px-5 md:px-10">
        <a href="#" class="text-2xl text-coffee" aria-label="Yâren ana sayfa">
            <x-logo />
        </a>

        <ul class="hidden items-center gap-10 md:flex">
            @foreach (config('yaren.links') as $link)
                <li>
                    <a href="{{ $link['href'] }}" class="group relative text-sm font-medium text-coffee/80 transition-colors hover:text-coffee">
                        {{ $link['label'] }}
                        <span class="absolute -bottom-1.5 left-1/2 h-1 w-1 -translate-x-1/2 scale-0 rounded-full bg-olive transition-transform duration-300 group-hover:scale-100"></span>
                    </a>
                </li>
            @endforeach
        </ul>

        <a href="#kahveler" class="hidden rounded-full border border-coffee/20 px-5 py-2 text-sm font-medium text-coffee transition-colors hover:border-coffee hover:bg-coffee hover:text-cream md:inline-flex">
            Sipariş Ver
        </a>

        <button
            type="button"
            class="inline-flex size-11 items-center justify-center rounded-full border border-coffee/20 text-coffee md:hidden"
            aria-expanded="false"
            aria-controls="mobile-menu"
            aria-label="Menüyü aç"
            data-menu-toggle
        >
            <x-icon name="menu" class="size-5" data-menu-icon="closed" />
            <x-icon name="x" class="size-5" data-menu-icon="open" hidden />
        </button>
    </nav>

    <div id="mobile-menu" class="invisible fixed inset-x-0 top-18 bottom-0 -translate-y-4 bg-cream px-6 pt-8 opacity-0 transition-all duration-500 md:hidden">
        <ul class="flex flex-col">
            @foreach (config('yaren.links') as $link)
                <li class="border-b border-coffee/10">
                    <a href="{{ $link['href'] }}" class="flex items-baseline justify-between py-5 font-serif text-4xl text-coffee">
                        {{ $link['label'] }}
                        <span class="font-sans text-xs text-olive">0{{ $loop->iteration }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
        <p class="mt-10 font-serif text-lg italic text-coffee/70">Her fincanda ortak bir hikâye.</p>
    </div>
</header>
