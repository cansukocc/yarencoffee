<section id="sss" aria-labelledby="sss-title" class="mx-auto max-w-7xl px-5 pb-24 md:px-10 md:pb-36">
    <div class="grid gap-10 md:grid-cols-12 md:gap-14">
        <x-reveal class="md:col-span-5">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-olive-ink">Merak Edilenler</p>
            <h2 id="sss-title" class="mt-5 font-serif text-5xl leading-none text-coffee md:text-7xl">
                Sıkça Sorulan <em class="text-olive">Sorular</em>
            </h2>
        </x-reveal>

        <x-reveal :delay="150" class="md:col-span-7">
            <div class="divide-y divide-coffee/15 border-y border-coffee/15">
                @foreach (config('yaren.faq') as $item)
                    <details class="group" data-faq-item>
                        <summary class="flex cursor-pointer list-none items-center justify-between gap-6 py-6 [&::-webkit-details-marker]:hidden">
                            <h3 class="font-serif text-2xl leading-snug text-coffee">{{ $item['question'] }}</h3>
                            <span class="inline-flex size-9 shrink-0 items-center justify-center rounded-full border border-coffee/20 text-coffee transition-transform duration-300 group-open:rotate-45">
                                <x-icon name="plus" class="size-4" />
                            </span>
                        </summary>
                        <div class="overflow-hidden" data-faq-content>
                            <p class="max-w-xl pb-6 leading-relaxed text-coffee/75">{{ $item['answer'] }}</p>
                        </div>
                    </details>
                @endforeach
            </div>
        </x-reveal>
    </div>
</section>
