<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        if (Product::query()->exists()) {
            return;
        }

        $products = [
            [
                'name' => 'Türk Kahvesi',
                'note' => 'Bakır cezvede',
                'description' => 'İnce öğütülmüş çekirdekler, kısık ateşte ağır ağır pişer. Bol köpüklü, yanında su ve lokumla.',
                'price' => 120,
                'image' => 'images/turk-kahvesi.webp',
                'image_alt' => 'Fincanda köpüklü Türk kahvesi, yanında su ve lokum',
            ],
            [
                'name' => 'Espresso',
                'note' => 'Çift shot',
                'description' => 'Kakao ve kavrulmuş fındık notalı yoğun bir shot. Kısa, cesur ve kadife kremalı.',
                'price' => 95,
                'image' => 'images/espresso.webp',
                'image_alt' => 'Ahşap zemin üzerinde kremalı espresso',
            ],
            [
                'name' => 'Filtre Kahve',
                'note' => 'V60 demleme',
                'description' => 'Tek kökenli çekirdekler, elle ve sabırla demlenir. Berrak, meyvemsi ve hafif.',
                'price' => 110,
                'image' => 'images/filtre.webp',
                'image_alt' => 'Seramik demleyici ile hazırlanan filtre kahve',
            ],
        ];

        foreach ($products as $index => $product) {
            Product::firstOrCreate(
                ['name' => $product['name']],
                [...$product, 'sort_order' => $index + 1],
            );
        }
    }
}
