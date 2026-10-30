<section class="relative -mt-18 overflow-hidden pt-18">
    <div class="mx-auto grid max-w-7xl items-center gap-10 px-5 pb-16 pt-10 md:grid-cols-12 md:px-10 md:pb-24 md:pt-16">
        <div class="relative z-10 md:col-span-6">
            <p class="mb-6 inline-flex items-center gap-2 rounded-full border border-olive/30 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-olive animate-in fade-in slide-in-from-bottom-2 duration-700">
                <span class="size-1.5 rounded-full bg-olive"></span>
                Est. 2026 · İstanbul
            </p>
            <h1 class="font-serif text-[22vw] leading-[0.85] font-light tracking-tight text-coffee md:text-[11rem] animate-in fade-in slide-in-from-bottom-6 duration-1000">
                Yâren
            </h1>
            <p class="mt-6 max-w-md font-serif text-3xl italic leading-tight text-coffee md:text-4xl animate-in fade-in slide-in-from-bottom-4 duration-1000 delay-200 fill-mode-both">
                Her fincanda ortak bir hikâye.
            </p>
            <p class="mt-5 max-w-md text-base leading-relaxed text-coffee/70 animate-in fade-in duration-1000 delay-300 fill-mode-both">
                Cezvenin sabrını espressonun cesaretiyle buluşturuyoruz. Kırk yıllık hatıra, bir yudumluk sohbet.
            </p>
            <div class="mt-9 flex flex-wrap items-center gap-4 animate-in fade-in duration-1000 delay-500 fill-mode-both">
                <a href="#kahveler" class="group inline-flex items-center gap-3 rounded-full bg-olive py-2 pl-7 pr-2 text-sm font-semibold text-cream transition-all hover:bg-coffee">
                    Kahveleri Keşfet
                    <span class="inline-flex size-10 items-center justify-center rounded-full bg-cream text-olive transition-transform duration-300 group-hover:translate-y-0.5 group-hover:text-coffee">
                        <x-icon name="arrow-down" class="size-4" />
                    </span>
                </a>
                <a href="#hikayemiz" class="text-sm font-medium text-coffee underline decoration-olive/50 underline-offset-[6px] hover:decoration-olive">
                    Hikâyemizi oku
                </a>
            </div>
        </div>

        <div class="relative md:col-span-6">
            <div class="relative mx-auto aspect-[4/5] w-full max-w-[520px]">
                <div class="absolute inset-0 overflow-hidden rounded-t-[999px] rounded-b-[3rem] bg-secondary shadow-[0_40px_80px_-30px_rgba(59,36,24,0.45)]">
                    <img
                        src="{{ asset('images/hero-cup.webp') }}"
                        alt="Ahşap zemin üzerinde köpüklü Türk kahvesi fincanı"
                        width="1400"
                        height="764"
                        loading="eager"
                        fetchpriority="high"
                        class="absolute inset-0 size-full object-cover"
                    >
                </div>

                <div aria-hidden="true" class="pointer-events-none absolute left-1/2 top-[18%] flex -translate-x-1/2 gap-5">
                    @foreach ([0, 1.2, 2.4] as $delay)
                        <span class="steam block h-24 w-5 rounded-full bg-cream/70 blur-md" style="animation-delay: {{ $delay }}s"></span>
                    @endforeach
                </div>

                <div class="absolute -left-4 bottom-10 hidden size-36 items-center justify-center md:-left-12 md:flex">
                    <svg viewBox="0 0 200 200" class="spin-slow absolute inset-0 text-coffee" aria-hidden="true">
                        <defs>
                            <path id="circlePath" d="M100,100 m-80,0 a80,80 0 1,1 160,0 a80,80 0 1,1 -160,0" />
                        </defs>
                        <text class="fill-current text-[15px] font-semibold uppercase tracking-[0.22em]">
                            <textPath href="#circlePath">Taze kavrulmuş · Elde demlenmiş · </textPath>
                        </text>
                    </svg>
                    <span class="flex size-16 items-center justify-center rounded-full bg-olive font-serif text-2xl italic text-cream">
                        Y
                    </span>
                </div>

                <div class="float-slow absolute -right-2 top-12 rounded-2xl bg-coffee px-5 py-4 text-cream shadow-xl md:-right-8">
                    <p class="text-[10px] uppercase tracking-[0.25em] text-cream/60">Bugünün demi</p>
                    <p class="mt-1 font-serif text-xl">Orta kavrum</p>
                </div>
            </div>
        </div>
    </div>

    <div class="border-y border-coffee/15 bg-coffee py-4 text-cream" aria-hidden="true">
        <div class="marquee flex w-max gap-10 whitespace-nowrap font-serif text-2xl italic">
            @foreach ([1, 2, 3, 4] as $repeat)
                @foreach (config('yaren.marquee') as $item)
                    <span class="flex items-center gap-10">
                        {{ $item }}
                        <span class="text-olive">✦</span>
                    </span>
                @endforeach
            @endforeach
        </div>
    </div>
</section>
