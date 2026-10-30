<footer class="bg-coffee text-cream">
    <div class="mx-auto max-w-7xl px-5 pb-10 pt-20 md:px-10">
        <div class="flex flex-col justify-between gap-10 md:flex-row md:items-end">
            <div>
                <x-logo class="text-5xl md:text-6xl" />
                <p class="mt-4 font-serif text-2xl italic text-cream/70">Her fincanda ortak bir hikâye.</p>
            </div>
            <ul class="flex gap-3">
                @foreach (config('yaren.socials') as $social)
                    <li>
                        <a
                            href="{{ $social['href'] }}"
                            aria-label="{{ $social['label'] }}"
                            class="flex size-12 items-center justify-center rounded-full border border-cream/20 transition-colors hover:border-olive hover:bg-olive"
                        >
                            <x-social-icon :name="$social['icon']" />
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div aria-hidden="true" class="mt-16 select-none overflow-hidden font-serif text-[26vw] leading-[0.75] font-light text-cream/[0.06] md:text-[18rem]">
            Yâren
        </div>

        <div class="mt-8 flex flex-col justify-between gap-4 border-t border-cream/15 pt-8 text-sm text-cream/60 md:flex-row">
            <p>© 2026 Yâren. Tüm hakları saklıdır.</p>
            <p>Kadıköy, İstanbul’da sevgiyle kavrulur.</p>
        </div>
    </div>
</footer>
