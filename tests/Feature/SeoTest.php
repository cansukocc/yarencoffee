<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use SimpleXMLElement;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->withoutVite();
    }

    private function graph(): array
    {
        preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $this->get('/')->getContent(), $matches);

        return json_decode($matches[1], true, flags: JSON_THROW_ON_ERROR)['@graph'];
    }

    private function node(string $type): array
    {
        return collect($this->graph())->firstWhere('@type', $type);
    }

    private function menuItems(): array
    {
        return $this->node('CafeOrCoffeeShop')['hasMenu']['hasMenuSection']['hasMenuItem'];
    }

    public function test_title_and_description_come_from_settings(): void
    {
        $this->get('/')
            ->assertSee('<title>Yâren | Türk Kahvesi, Espresso ve Filtre Kahve</title>', false);

        Setting::where('key', 'meta_title')->update(['value' => 'Yeni başlık']);
        Setting::where('key', 'meta_description')->update(['value' => 'Yeni açıklama']);

        $this->get('/')
            ->assertSee('<title>Yeni başlık</title>', false)
            ->assertSee('<meta name="description" content="Yeni açıklama">', false)
            ->assertSee('<meta property="og:title" content="Yeni başlık">', false)
            ->assertSee('<meta name="twitter:description" content="Yeni açıklama">', false)
            ->assertSee('Her fincanda ortak bir hikâye.');
    }

    public function test_seeded_meta_fits_the_limits(): void
    {
        $this->assertLessThanOrEqual(60, mb_strlen(Setting::find('meta_title')->value));
        $this->assertLessThanOrEqual(160, mb_strlen(Setting::find('meta_description')->value));
    }

    public function test_canonical_and_share_tags_are_correct(): void
    {
        $this->get('/')
            ->assertSee('<link rel="canonical" href="'.url('/').'/">', false)
            ->assertSee('<meta property="og:url" content="'.url('/').'/">', false)
            ->assertSee('<meta property="og:image" content="'.asset('images/og-cover.jpg').'">', false)
            ->assertSee('<meta property="og:image:width" content="1200">', false)
            ->assertSee('<meta property="og:image:height" content="630">', false);
    }

    public function test_structured_data_lists_products_with_try_prices(): void
    {
        $items = collect($this->menuItems());

        $this->assertSame(['Türk Kahvesi', 'Espresso', 'Filtre Kahve'], $items->pluck('name')->all());
        $this->assertSame([120, 95, 110], $items->pluck('offers.price')->all());
        $this->assertSame(['TRY'], $items->pluck('offers.priceCurrency')->unique()->all());
    }

    public function test_structured_data_uses_settings(): void
    {
        Setting::where('key', 'contact_phone')->update(['value' => '+90 216 111 11 11']);

        $shop = $this->node('CafeOrCoffeeShop');

        $this->assertSame('+90 216 111 11 11', $shop['telephone']);
        $this->assertSame('Moda Caddesi No. 12, Kadıköy / İstanbul', $shop['address']['streetAddress']);
        $this->assertSame('₺95-₺120', $shop['priceRange']);
        $this->assertNotNull($this->node('WebSite'));
    }

    public function test_inactive_product_is_not_in_structured_data(): void
    {
        Product::where('name', 'Espresso')->update(['is_active' => false]);

        $this->assertSame(['Türk Kahvesi', 'Filtre Kahve'], array_column($this->menuItems(), 'name'));
    }

    public function test_structured_data_keeps_turkish_and_cannot_close_the_script_tag(): void
    {
        Setting::where('key', 'meta_description')->update(['value' => 'ğüşıİçöâ </script><b>']);

        $html = $this->get('/')->getContent();

        $this->assertStringContainsString('"description":"ğüşıİçöâ ', $html);
        $this->assertStringNotContainsString('ğüşıİçöâ </script>', $html);
        $this->assertSame('ğüşıİçöâ </script><b>', $this->node('WebSite')['description']);
    }

    public function test_faq_questions_are_on_the_page_and_in_structured_data(): void
    {
        $questions = array_column(config('yaren.faq'), 'question');

        $this->assertCount(4, $questions);
        $this->assertSame($questions, array_column($this->node('FAQPage')['mainEntity'], 'name'));
        $this->get('/')->assertSeeInOrder($questions);
    }

    public function test_sitemap_is_valid_xml_with_home_page_only(): void
    {
        $response = $this->get('/sitemap.xml')->assertOk();

        $this->assertStringContainsString('application/xml', $response->headers->get('Content-Type'));

        $xml = new SimpleXMLElement($response->getContent());

        $this->assertCount(1, $xml->url);
        $this->assertSame(url('/').'/', (string) $xml->url->loc);
        $this->assertStringNotContainsString('yonetim', $response->getContent());
    }

    public function test_sitemap_lastmod_follows_latest_change(): void
    {
        Product::query()->update(['updated_at' => '2026-01-01 10:00:00']);
        Setting::query()->update(['updated_at' => '2026-02-02 10:00:00']);

        $xml = new SimpleXMLElement($this->get('/sitemap.xml')->getContent());

        $this->assertStringStartsWith('2026-02-02T10:00:00', (string) $xml->url->lastmod);
    }

    public function test_robots_lists_sitemap_and_blocks_admin(): void
    {
        $robots = file_get_contents(public_path('robots.txt'));

        $this->assertStringContainsString('Sitemap: https://baghouse.com.tr/sitemap.xml', $robots);
        $this->assertStringContainsString('Disallow: /yonetim', $robots);
    }
}
