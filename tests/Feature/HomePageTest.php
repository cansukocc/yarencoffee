<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Setting;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_home_page_shows_brand_and_call_to_action(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Yâren')
            ->assertSee('Her fincanda ortak bir hikâye.')
            ->assertSee('Kahveleri Keşfet')
            ->assertSee('href="#kahveler"', false);
    }

    public function test_home_page_lists_products_with_prices(): void
    {
        $this->get('/')
            ->assertSeeInOrder(['Türk Kahvesi', '₺120', 'Espresso', '₺95', 'Filtre Kahve', '₺110']);
    }

    public function test_home_page_has_contact_form_fields(): void
    {
        $this->get('/')
            ->assertSee('name="name"', false)
            ->assertSee('name="email"', false)
            ->assertSee('name="message"', false);
    }

    public function test_inactive_products_are_hidden(): void
    {
        Product::where('name', 'Espresso')->update(['is_active' => false]);

        $this->get('/')
            ->assertDontSee('₺95')
            ->assertSee('₺120');
    }

    public function test_products_follow_sort_order(): void
    {
        Product::where('name', 'Filtre Kahve')->update(['sort_order' => 0]);

        $this->get('/')
            ->assertSeeInOrder(['₺110', '₺120', '₺95']);
    }

    public function test_changing_slogan_updates_the_page(): void
    {
        Setting::where('key', 'slogan')->update(['value' => 'Yeni bir slogan.']);

        $this->get('/')
            ->assertSee('Yeni bir slogan.')
            ->assertSee('<title>Yâren — Yeni bir slogan</title>', false)
            ->assertDontSee('Her fincanda ortak bir hikâye.');
    }

    public function test_seeding_again_keeps_admin_changes(): void
    {
        Product::where('name', 'Espresso')->update(['name' => 'Doppio', 'price' => 150]);
        Setting::where('key', 'slogan')->update(['value' => 'Yeni bir slogan.']);

        $this->seed(DatabaseSeeder::class);

        $this->assertSame(3, Product::count());
        $this->assertSame(150, Product::where('name', 'Doppio')->value('price'));
        $this->assertSame(6, Setting::count());
        $this->assertSame('Yeni bir slogan.', Setting::find('slogan')->value);
    }
}
