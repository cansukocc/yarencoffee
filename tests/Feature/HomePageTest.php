<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_home_page_shows_brand_and_call_to_action(): void
    {
        $this->withoutVite();

        $this->get('/')
            ->assertOk()
            ->assertSee('Yâren')
            ->assertSee('Her fincanda ortak bir hikâye.')
            ->assertSee('Kahveleri Keşfet')
            ->assertSee('href="#kahveler"', false);
    }

    public function test_home_page_lists_products_with_prices(): void
    {
        $this->withoutVite();

        $this->get('/')
            ->assertSeeInOrder(['Türk Kahvesi', '₺120', 'Espresso', '₺95', 'Filtre Kahve', '₺110']);
    }

    public function test_home_page_has_contact_form_fields(): void
    {
        $this->withoutVite();

        $this->get('/')
            ->assertSee('name="name"', false)
            ->assertSee('name="email"', false)
            ->assertSee('name="message"', false);
    }
}
