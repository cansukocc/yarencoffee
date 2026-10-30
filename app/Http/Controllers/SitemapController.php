<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $lastModified = collect([Product::query()->max('updated_at'), Setting::query()->max('updated_at')])
            ->filter()
            ->max();

        return response()
            ->view('sitemap', ['lastModified' => $lastModified ? Carbon::parse($lastModified)->toAtomString() : null])
            ->header('Content-Type', 'application/xml');
    }
}
