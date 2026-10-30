<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'products' => [
                [
                    'name' => 'Türk Kahvesi',
                    'price' => 120,
                    'image' => 'images/turk-kahvesi.webp',
                    'alt' => 'Fincanda köpüklü Türk kahvesi, yanında su ve lokum',
                    'note' => 'Bakır cezvede',
                    'description' => 'İnce öğütülmüş çekirdekler, kısık ateşte ağır ağır pişer. Bol köpüklü, yanında su ve lokumla.',
                ],
                [
                    'name' => 'Espresso',
                    'price' => 95,
                    'image' => 'images/espresso.webp',
                    'alt' => 'Ahşap zemin üzerinde kremalı espresso',
                    'note' => 'Çift shot',
                    'description' => 'Kakao ve kavrulmuş fındık notalı yoğun bir shot. Kısa, cesur ve kadife kremalı.',
                ],
                [
                    'name' => 'Filtre Kahve',
                    'price' => 110,
                    'image' => 'images/filtre.webp',
                    'alt' => 'Seramik demleyici ile hazırlanan filtre kahve',
                    'note' => 'V60 demleme',
                    'description' => 'Tek kökenli çekirdekler, elle ve sabırla demlenir. Berrak, meyvemsi ve hafif.',
                ],
            ],
        ]);
    }
}
