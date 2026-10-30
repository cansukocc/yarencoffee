<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'slogan' => 'Her fincanda ortak bir hikâye.',
            'hero_subtitle' => 'Cezvenin sabrını espressonun cesaretiyle buluşturuyoruz. Kırk yıllık hatıra, bir yudumluk sohbet.',
            'hero_badge' => 'Est. 2026 · İstanbul',
            'contact_address' => 'Moda Caddesi No. 12, Kadıköy / İstanbul',
            'contact_email' => 'merhaba@yaren.coffee',
            'contact_phone' => '+90 212 000 00 00',
            'meta_title' => 'Yâren | Türk Kahvesi, Espresso ve Filtre Kahve',
            'meta_description' => "Yâren'de geleneksel Türk kahvesi, espresso ve filtre kahve aynı masada buluşuyor. Bakır cezvede pişen lezzetleri keşfedin, bir fincan sohbete gelin.",
        ];

        foreach ($settings as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
