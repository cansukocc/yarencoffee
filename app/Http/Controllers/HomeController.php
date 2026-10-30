<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use App\Support\StructuredData;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $products = Product::query()->visible()->get();
        $settings = Setting::allAsArray();

        return view('home', [
            'products' => $products,
            'settings' => $settings,
            'structuredData' => (new StructuredData($settings, $products))->toJson(),
        ]);
    }
}
