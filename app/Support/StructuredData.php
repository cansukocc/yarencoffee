<?php

namespace App\Support;

use App\Models\Product;
use Illuminate\Support\Collection;

class StructuredData
{
    private string $homeUrl;

    /**
     * @param  array<string, string|null>  $settings
     * @param  Collection<int, Product>  $products
     */
    public function __construct(private array $settings, private Collection $products)
    {
        $this->homeUrl = url('/').'/';
    }

    public function toJson(): string
    {
        return json_encode(
            ['@context' => 'https://schema.org', '@graph' => [$this->webSite(), $this->coffeeShop(), $this->faqPage()]],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_THROW_ON_ERROR,
        );
    }

    private function webSite(): array
    {
        return [
            '@type' => 'WebSite',
            '@id' => "{$this->homeUrl}#website",
            'url' => $this->homeUrl,
            'name' => config('app.name'),
            'description' => $this->settings['meta_description'],
            'inLanguage' => 'tr-TR',
        ];
    }

    private function coffeeShop(): array
    {
        return [
            '@type' => 'CafeOrCoffeeShop',
            '@id' => "{$this->homeUrl}#coffeeshop",
            'name' => config('app.name'),
            'url' => $this->homeUrl,
            'image' => asset('images/og-cover.jpg'),
            'description' => $this->settings['meta_description'],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $this->settings['contact_address'],
                'addressCountry' => config('yaren.seo.country'),
            ],
            'telephone' => $this->settings['contact_phone'],
            'email' => $this->settings['contact_email'],
            'servesCuisine' => config('yaren.seo.cuisines'),
            'priceRange' => "₺{$this->products->min('price')}-₺{$this->products->max('price')}",
            'hasMenu' => $this->menu(),
        ];
    }

    private function menu(): array
    {
        return [
            '@type' => 'Menu',
            'name' => config('app.name').' Menü',
            'hasMenuSection' => [
                '@type' => 'MenuSection',
                'name' => 'Kahveler',
                'hasMenuItem' => $this->products->map(fn (Product $product) => $this->menuItem($product))->values()->all(),
            ],
        ];
    }

    private function menuItem(Product $product): array
    {
        return [
            '@type' => 'MenuItem',
            'name' => $product->name,
            'description' => $product->description,
            'image' => asset($product->image),
            'offers' => [
                '@type' => 'Offer',
                'price' => $product->price,
                'priceCurrency' => config('yaren.seo.currency'),
            ],
        ];
    }

    private function faqPage(): array
    {
        return [
            '@type' => 'FAQPage',
            '@id' => "{$this->homeUrl}#faq",
            'mainEntity' => array_map(fn (array $item) => [
                '@type' => 'Question',
                'name' => $item['question'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item['answer']],
            ], config('yaren.faq')),
        ];
    }
}
