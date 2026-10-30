<section id="hikayemiz" class="mx-auto max-w-7xl px-5 py-24 md:px-10 md:py-36">
    <div class="grid gap-12 md:grid-cols-2 md:gap-16">
        <x-reveal class="relative order-2 md:order-1">
            <div class="relative overflow-hidden rounded-[2.5rem] p-6 md:p-10" style="background-image: url('{{ asset('images/wood.webp') }}'); background-size: cover">
                <div class="absolute inset-0 bg-coffee/40" aria-hidden="true"></div>
                <div class="relative aspect-[4/5] overflow-hidden rounded-t-[999px] rounded-b-[1.75rem]">
                    <img
                        src="{{ asset('images/story.webp') }}"
                        alt="Cezveden fincana dökülen Türk kahvesi ve yanında espresso"
                        width="1400"
                        height="764"
                        loading="lazy"
                        decoding="async"
                        class="absolute inset-0 size-full object-cover"
                        data-parallax
                    >
                </div>
                <div class="relative mt-6 flex items-center justify-between text-cream">
                    <p class="font-serif text-lg italic">Cezve &amp; Portafiltre</p>
                    <p class="text-xs uppercase tracking-[0.25em] text-cream/70">No. 01</p>
                </div>
            </div>
        </x-reveal>

        <div class="order-1 flex flex-col justify-center md:order-2">
            <x-reveal>
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-olive-ink">Hikâyemiz</p>
            </x-reveal>
            <h2 class="mt-5 text-balance font-serif text-5xl leading-[1.02] text-coffee md:text-7xl" data-words>
                <span class="inline-block" data-word>Gelenek</span>
                <span class="inline-block" data-word>ile</span>
                <em class="inline-block text-olive" data-word>bugün</em>
                <span class="inline-block" data-word>aynı</span>
                <span class="inline-block" data-word>masada.</span>
            </h2>
            <x-reveal :delay="150">
                <p class="mt-8 max-w-lg text-pretty text-lg leading-relaxed text-coffee/75">
                    Yâren, büyükannelerimizin bakır cezvesinde köpürttüğü kahveyle başladı. O kokuyu, o sabrı ve
                    o sohbeti; bugünün espresso barlarına ve özenli demleme ritüellerine taşıdık.
                </p>
                <p class="mt-5 max-w-lg text-pretty leading-relaxed text-coffee/75">
                    Adımız eski bir kelimeden geliyor: <span class="font-serif italic text-coffee">yâren</span>, yani
                    dost, sırdaş. Çünkü bizce kahve hiçbir zaman sadece kahve olmadı.
                </p>
            </x-reveal>

            <x-reveal :delay="300">
                <dl class="mt-12 grid grid-cols-2 gap-px overflow-hidden rounded-3xl border border-coffee/15 bg-coffee/15">
                    <div class="bg-cream p-6">
                        <dt class="text-xs uppercase tracking-[0.2em] text-coffee/60">Gelenek</dt>
                        <dd class="mt-2 font-serif text-2xl text-coffee">Bakır cezve, közde sabır</dd>
                    </div>
                    <div class="bg-cream p-6">
                        <dt class="text-xs uppercase tracking-[0.2em] text-coffee/60">Bugün</dt>
                        <dd class="mt-2 font-serif text-2xl text-coffee">9 bar basınç, gram hassasiyeti</dd>
                    </div>
                </dl>
            </x-reveal>
        </div>
    </div>
</section>
