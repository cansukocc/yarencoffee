<section id="kahveler" class="bg-secondary/60 py-24 md:py-36">
    <div class="mx-auto max-w-7xl px-5 md:px-10">
        <x-reveal class="flex flex-col justify-between gap-6 md:flex-row md:items-end">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-olive">Kahvelerimiz</p>
                <h2 class="mt-5 font-serif text-5xl leading-none text-coffee md:text-7xl">
                    Üç fincan, <em class="text-olive">üç ritüel.</em>
                </h2>
            </div>
            <p class="max-w-sm leading-relaxed text-coffee/70">
                Her biri kendi zamanına, kendi sohbetine ait. Hangisi bugünün ruh haline uyar?
            </p>
        </x-reveal>

        <ul class="mt-14 grid gap-6 md:grid-cols-3 md:gap-8">
            @foreach ($products as $product)
                <x-reveal as="li" :delay="$loop->index * 120">
                    <article class="group flex h-full flex-col rounded-[2rem] bg-card p-3 shadow-[0_1px_0_0_var(--border)] transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_30px_60px_-30px_rgba(59,36,24,0.4)]">
                        <div class="relative aspect-square overflow-hidden rounded-t-[999px] rounded-b-[1.5rem] bg-secondary">
                            <img
                                src="{{ asset($product['image']) }}"
                                alt="{{ $product['alt'] }}"
                                width="1400"
                                height="764"
                                loading="lazy"
                                decoding="async"
                                class="absolute inset-0 size-full object-cover transition-transform duration-700 group-hover:scale-105"
                            >
                            <span class="absolute bottom-4 left-4 rounded-full bg-cream/90 px-3 py-1 text-xs font-medium text-coffee backdrop-blur">
                                {{ $product['note'] }}
                            </span>
                        </div>
                        <div class="flex flex-1 flex-col px-4 pb-4 pt-6">
                            <div class="flex items-start justify-between gap-4">
                                <h3 class="font-serif text-3xl text-coffee">{{ $product['name'] }}</h3>
                                <span class="shrink-0 rounded-full bg-olive px-3.5 py-1.5 text-sm font-semibold text-cream">
                                    ₺{{ $product['price'] }}
                                </span>
                            </div>
                            <p class="mt-3 flex-1 leading-relaxed text-coffee/70">{{ $product['description'] }}</p>
                            <button
                                type="button"
                                class="mt-6 inline-flex items-center justify-between rounded-full border border-coffee/20 py-1.5 pl-5 pr-1.5 text-sm font-medium text-coffee transition-colors hover:border-coffee hover:bg-coffee hover:text-cream"
                                data-product-inquiry="{{ $product['name'] }}"
                            >
                                Bu kahveyi sor
                                <span class="inline-flex size-8 items-center justify-center rounded-full bg-coffee text-cream transition-transform duration-300 group-hover:rotate-90">
                                    <x-icon name="plus" class="size-4" />
                                    <span class="sr-only">{{ $product['name'] }}</span>
                                </span>
                            </button>
                        </div>
                    </article>
                </x-reveal>
            @endforeach
        </ul>
    </div>
</section>
