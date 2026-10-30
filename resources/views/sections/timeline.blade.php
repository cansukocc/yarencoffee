<section id="rituel" class="relative overflow-hidden bg-coffee py-24 text-cream md:py-36">
    <div
        aria-hidden="true"
        class="absolute inset-0 opacity-25 mix-blend-overlay"
        style="background-image: url('{{ asset('images/wood.webp') }}'); background-size: cover"
    ></div>
    <div class="relative mx-auto max-w-7xl px-5 md:px-10">
        <x-reveal class="max-w-2xl">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-cream/60">Ritüel</p>
            <h2 class="mt-5 font-serif text-5xl leading-none md:text-7xl">
                Gelenekten <em class="text-[#a9ad7e]">Bugüne</em>
            </h2>
            <p class="mt-6 max-w-lg leading-relaxed text-cream/70">
                Beş asırlık bir yolculuk, tek bir fincanda. Demleme biçimleri değişti; masadaki sohbet aynı kaldı.
            </p>
        </x-reveal>

        <div class="relative mt-16">
            <span
                aria-hidden="true"
                class="absolute left-[2.25rem] top-0 h-full w-px border-l border-dashed border-cream/25 md:left-0 md:top-[2.25rem] md:h-px md:w-full md:border-l-0 md:border-t"
            ></span>

            <ol class="grid gap-12 md:grid-cols-3 md:gap-8">
                @foreach (config('yaren.timeline') as $step)
                    <x-reveal as="li" :delay="$loop->index * 180" class="relative pl-24 md:pl-0">
                        <span class="absolute left-0 top-0 flex size-18 items-center justify-center rounded-full border border-cream/25 bg-coffee font-serif text-2xl italic md:relative">
                            0{{ $loop->iteration }}
                        </span>
                        <div class="md:mt-8">
                            <div class="group relative aspect-[4/3] overflow-hidden rounded-t-[999px] rounded-b-3xl bg-cream">
                                <img
                                    src="{{ asset($step['image']) }}"
                                    alt="{{ $step['alt'] }}"
                                    width="1400"
                                    height="764"
                                    loading="lazy"
                                    decoding="async"
                                    style="object-position: {{ $step['position'] }}"
                                    class="absolute inset-0 size-full object-cover transition-transform duration-700 group-hover:scale-105"
                                >
                            </div>
                            <p class="mt-6 text-xs font-semibold uppercase tracking-[0.25em] text-[#a9ad7e]">{{ $step['year'] }}</p>
                            <h3 class="mt-2 font-serif text-3xl">{{ $step['title'] }}</h3>
                            <p class="mt-3 leading-relaxed text-cream/70">{{ $step['text'] }}</p>
                        </div>
                    </x-reveal>
                @endforeach
            </ol>
        </div>
    </div>
</section>
