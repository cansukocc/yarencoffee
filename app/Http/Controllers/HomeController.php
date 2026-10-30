<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'products' => Product::query()->visible()->get(),
            'settings' => Setting::allAsArray(),
        ]);
    }
}
