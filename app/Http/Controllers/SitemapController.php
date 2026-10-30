<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class SitemapController extends Controller
{
    private const XML_DECLARATION = '<?xml version="1.0" encoding="UTF-8"?>';

    public function __invoke(): Response
    {
        $lastModified = collect([Product::query()->max('updated_at'), Setting::query()->max('updated_at')])
            ->filter()
            ->max();

        $urlSet = view('sitemap', [
            'lastModified' => $lastModified ? Carbon::parse($lastModified)->toAtomString() : null,
        ])->render();

        return response(self::XML_DECLARATION."\n".$urlSet)->header('Content-Type', 'application/xml');
    }
}
