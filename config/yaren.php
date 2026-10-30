<?php

return [

    'contact_recipient' => env('CONTACT_RECIPIENT'),

    'admin' => [
        'name' => env('ADMIN_NAME'),
        'email' => env('ADMIN_EMAIL'),
        'password' => env('ADMIN_PASSWORD'),
    ],

    'seo' => [
        'cuisines' => ['Türk kahvesi', 'Espresso', 'Filtre kahve'],
        'country' => 'TR',
        'currency' => 'TRY',
    ],

    'faq' => [
        [
            'question' => 'Türk kahvesi nasıl pişirilir?',
            'answer' => 'İnce çekilmiş kahveyi soğuk suyla cezveye alın, isterseniz şekerini de ekleyin. Kısık ateşte karıştırmadan ısıtın; köpük yükselince fincanlara paylaştırın, kalanını bir kez daha kabartıp üzerine ekleyin.',
        ],
        [
            'question' => 'Espresso ile filtre kahve arasındaki fark nedir?',
            'answer' => 'Espressoda ince öğütülmüş kahveden basınçlı su geçer ve saniyeler içinde yoğun, kısa bir içim elde edilir. Filtre kahvede su kahveden yavaşça süzülür; sonuç daha hafif, berrak ve uzun bir fincandır.',
        ],
        [
            'question' => 'Bana hangi kahve uygun?',
            'answer' => 'Köpüklü ve yoğun bir ritüel istiyorsanız Türk kahvesi, kısa ve güçlü bir tat arıyorsanız espresso, yudumlayarak içmeyi seviyorsanız filtre kahve iyi bir başlangıçtır. Kararsızsanız bize yazın, birlikte seçelim.',
        ],
        [
            'question' => 'Toptan sipariş veya etkinlik için nasıl ulaşabilirim?',
            'answer' => 'Bu sayfadaki iletişim formundan ya da e-posta adresimizden bize yazabilirsiniz. Kişi sayısını ve tarihi belirtirseniz size daha hızlı dönüş yaparız.',
        ],
    ],

    'links' => [
        ['href' => '#hikayemiz', 'label' => 'Hikâyemiz'],
        ['href' => '#kahveler', 'label' => 'Kahveler'],
        ['href' => '#rituel', 'label' => 'Ritüel'],
        ['href' => '#iletisim', 'label' => 'İletişim'],
    ],

    'marquee' => ['Türk Kahvesi', 'Espresso', 'Filtre Kahve', 'Cezve', 'Telve', 'Köpük', 'Demleme'],

    'timeline' => [
        [
            'year' => '1500’ler',
            'title' => 'Cezve',
            'image' => 'images/cezve.webp',
            'alt' => 'Dövme bakır cezve',
            'position' => '75% 50%',
            'text' => 'İstanbul kahvehanelerinde doğan ritüel. Ağır ateş, bol köpük ve kırk yıllık hatır.',
        ],
        [
            'year' => '1900’ler',
            'title' => 'Espresso makinesi',
            'image' => 'images/espresso-machine.webp',
            'alt' => 'Kollu klasik espresso makinesi',
            'position' => '50% 50%',
            'text' => 'Basınçla gelen hız. Saniyeler içinde yoğun bir öz, kalabalık şehirlerin yeni nabzı.',
        ],
        [
            'year' => 'Bugün',
            'title' => 'Pour-over',
            'image' => 'images/pour-over.webp',
            'alt' => 'Seramik pour-over demleyici',
            'position' => '72% 50%',
            'text' => 'Gramla ölçülen sabır. Her çekirdeğin hikâyesini berrak bir fincanda anlatan demleme.',
        ],
    ],

    'fortunes' => [
        ['symbol' => 'Kuş', 'text' => 'Fincanında bir kuş var: yakında güzel bir haber kapını çalacak.'],
        ['symbol' => 'Yol', 'text' => 'Uzun bir yol görünüyor. Kısmetin bavulunda, hazırlıklı ol.'],
        ['symbol' => 'Kalp', 'text' => 'Telvede bir kalp beliriyor. Gönlün, beklediğin sohbete kavuşacak.'],
        ['symbol' => 'Balık', 'text' => 'Bir balık yüzüyor dibinde: bereketli, bol kazançlı günler yakın.'],
        ['symbol' => 'Anahtar', 'text' => 'Elinde bir anahtar var. Uzun zamandır kapalı bir kapı açılacak.'],
        ['symbol' => 'Ay', 'text' => 'Hilal parlıyor. Bu ay yeni bir başlangıca uygun, cesur ol.'],
    ],

    'socials' => [
        ['label' => 'Instagram', 'href' => '#', 'icon' => 'instagram'],
        ['label' => 'X', 'href' => '#', 'icon' => 'x'],
        ['label' => 'YouTube', 'href' => '#', 'icon' => 'youtube'],
    ],

];
