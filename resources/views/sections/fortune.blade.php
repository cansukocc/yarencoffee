<section aria-labelledby="fal-title" class="mx-auto max-w-7xl px-5 py-24 md:px-10 md:py-36" data-fortune="{{ json_encode(config('yaren.fortunes')) }}">
    <x-reveal>
        <div class="relative grid items-center gap-10 overflow-hidden rounded-[2.5rem] border border-olive/25 bg-[#ece6d2] p-8 md:grid-cols-2 md:p-16">
            <div aria-hidden="true" class="absolute -right-24 -top-24 size-72 rounded-full border border-olive/20"></div>
            <div aria-hidden="true" class="absolute -right-10 -top-10 size-44 rounded-full border border-olive/20"></div>

            <div class="relative">
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-olive">Bir kahvenin kırk yıl hatırı</p>
                <h2 id="fal-title" class="mt-5 font-serif text-5xl leading-none text-coffee md:text-7xl">
                    Telve <em class="text-olive">Falı</em>
                </h2>
                <p class="mt-6 max-w-md leading-relaxed text-coffee/70">
                    Kahveni bitirdin mi? Fincanı tabağa kapat, bir dilek tut ve soğumasını bekle. Gerisini telveye bırak.
                </p>

                <div aria-live="polite" class="mt-8 min-h-32">
                    <p class="font-serif text-2xl italic text-coffee/40" data-fortune-panel="idle">Fincanın seni bekliyor.</p>
                    <p class="font-serif text-2xl italic text-coffee/70" data-fortune-panel="reading" hidden>Fincan soğuyor, telve konuşuyor…</p>
                    <div class="animate-in fade-in slide-in-from-bottom-3 duration-700 rounded-3xl bg-cream p-6 shadow-[0_20px_40px_-25px_rgba(59,36,24,0.5)]" data-fortune-panel="done" hidden>
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-olive">Telvede: <span data-fortune-symbol></span></p>
                        <p class="mt-3 font-serif text-2xl leading-snug text-coffee" data-fortune-text></p>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap gap-3">
                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-full bg-olive px-7 py-3.5 text-sm font-semibold text-cream transition-colors hover:bg-coffee disabled:opacity-60"
                        data-fortune-button
                    >
                        <x-icon name="sparkles" class="size-4" data-fortune-icon="read" />
                        <x-icon name="rotate-ccw" class="size-4" data-fortune-icon="again" hidden />
                        <span data-fortune-label>Falına Bak</span>
                    </button>
                </div>
            </div>

            <div class="relative flex justify-center py-6">
                <div class="relative transition-transform duration-[1600ms] ease-[cubic-bezier(0.6,0,0.2,1)]" data-fortune-stage>
                    <svg viewBox="0 0 260 240" class="w-64 md:w-80" role="img" aria-label="Tabağa ters kapatılmış kahve fincanı">
                        <ellipse cx="130" cy="205" rx="118" ry="22" fill="#3B2418" opacity="0.15" />
                        <ellipse cx="130" cy="198" rx="112" ry="20" fill="#F5F0E6" stroke="#3B2418" stroke-width="2" />
                        <ellipse cx="130" cy="196" rx="70" ry="10" fill="none" stroke="#6B7045" stroke-width="1.5" stroke-dasharray="3 5" />
                        <g class="opacity-0 transition-opacity duration-700" data-fortune-telve>
                            <ellipse cx="130" cy="196" rx="52" ry="7" fill="#3B2418" opacity="0.85" />
                        </g>
                        <g class="transition-transform duration-1000" style="transform-origin: 130px 192px" data-fortune-cup>
                            <path d="M72 192 C72 120 95 70 130 70 C165 70 188 120 188 192 Z" fill="#F5F0E6" stroke="#3B2418" stroke-width="2" />
                            <path d="M84 150 Q130 162 176 150" fill="none" stroke="#6B7045" stroke-width="5" />
                            <path d="M80 165 Q130 177 180 165" fill="none" stroke="#6B7045" stroke-width="1.5" />
                            <path d="M98 118 l6 -10 l6 10 l-6 10 z M124 112 l6 -10 l6 10 l-6 10 z M150 118 l6 -10 l6 10 l-6 10 z" fill="#6B7045" />
                            <path d="M188 120 C216 116 222 160 190 160" fill="none" stroke="#3B2418" stroke-width="2" />
                            <ellipse cx="130" cy="192" rx="58" ry="5" fill="#3B2418" opacity="0.2" />
                        </g>
                        <g fill="none" stroke="#3B2418" stroke-width="1.5" stroke-linecap="round" opacity="0.35">
                            <path d="M110 50 c-8 -10 8 -16 0 -28" />
                            <path d="M150 50 c-8 -10 8 -16 0 -28" />
                        </g>
                    </svg>
                </div>
            </div>
        </div>
    </x-reveal>
</section>
