<section id="iletisim" class="bg-secondary/60 py-24 md:py-36">
    <div class="mx-auto grid max-w-7xl gap-14 px-5 md:grid-cols-12 md:px-10">
        <x-reveal class="md:col-span-5">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-olive">İletişim</p>
            <h2 class="mt-5 font-serif text-5xl leading-none text-coffee md:text-7xl">
                Bir fincan <em class="text-olive">sohbet?</em>
            </h2>
            <p class="mt-6 max-w-sm leading-relaxed text-coffee/70">
                Toptan sipariş, etkinlik ya da sadece merhaba demek için. Kahveyi biz koyarız.
            </p>
            <ul class="mt-10 space-y-5 text-coffee">
                <li class="flex items-center gap-4">
                    <span class="flex size-11 items-center justify-center rounded-full border border-coffee/15"><x-icon name="map-pin" class="size-4" /></span>
                    Moda Caddesi No. 12, Kadıköy / İstanbul
                </li>
                <li class="flex items-center gap-4">
                    <span class="flex size-11 items-center justify-center rounded-full border border-coffee/15"><x-icon name="mail" class="size-4" /></span>
                    merhaba@yaren.coffee
                </li>
                <li class="flex items-center gap-4">
                    <span class="flex size-11 items-center justify-center rounded-full border border-coffee/15"><x-icon name="phone" class="size-4" /></span>
                    +90 212 000 00 00
                </li>
            </ul>
        </x-reveal>

        <x-reveal :delay="150" class="md:col-span-7">
            <div
                role="status"
                class="flex h-full flex-col items-start justify-center rounded-[2rem] bg-olive p-8 text-cream animate-in fade-in zoom-in-95 duration-500 md:p-12"
                data-contact-success
                hidden
            >
                <x-icon name="circle-check" class="size-12" />
                <h3 class="mt-6 font-serif text-4xl">Mesajınız yolda.</h3>
                <p class="mt-3 max-w-md leading-relaxed text-cream/85" data-contact-success-message></p>
                <a href="#iletisim" class="mt-8 text-sm font-semibold underline underline-offset-4" data-contact-reset>
                    Yeni mesaj gönder
                </a>
            </div>

            <form novalidate class="rounded-[2rem] bg-card p-6 shadow-[0_30px_60px_-40px_rgba(59,36,24,0.5)] md:p-10" data-contact-form>
                <div role="alert" class="mb-6 flex items-start gap-3 rounded-2xl border border-destructive/30 bg-destructive/10 p-4 text-sm text-destructive" data-contact-alert hidden>
                    <x-icon name="circle-alert" class="mt-0.5 size-4 shrink-0" />
                    <span data-contact-alert-message></span>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <x-field label="Ad" name="name" placeholder="Adınız" autocomplete="name" />
                    <x-field label="E-posta" name="email" type="email" placeholder="ornek@eposta.com" autocomplete="email" />
                </div>
                <div class="mt-5">
                    <x-field label="Mesaj" name="message" placeholder="Aklınızdan geçenleri yazın…" textarea />
                </div>

                <button
                    type="submit"
                    class="group mt-8 inline-flex w-full items-center justify-center gap-3 rounded-full bg-coffee px-8 py-4 text-sm font-semibold text-cream transition-colors hover:bg-olive disabled:opacity-70 md:w-auto"
                >
                    <span class="inline-flex items-center gap-3" data-contact-submit="idle">
                        Mesajı Gönder
                        <x-icon name="arrow-up-right" class="size-4 transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5" />
                    </span>
                    <span class="inline-flex items-center gap-3" data-contact-submit="pending" hidden>
                        <x-icon name="loader-circle" class="size-4 animate-spin" />
                        Gönderiliyor…
                    </span>
                </button>
            </form>
        </x-reveal>
    </div>
</section>
