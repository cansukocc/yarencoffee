<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsManagementTest extends TestCase
{
    use RefreshDatabase;

    private array $settings = [
        'slogan' => 'Yeni bir slogan.',
        'hero_subtitle' => 'Yeni giriş metni.',
        'hero_badge' => 'Est. 2027',
        'contact_address' => 'Yeni adres',
        'contact_email' => 'yeni@example.com',
        'contact_phone' => '+90 216 000 00 00',
        'meta_title' => 'Yeni başlık',
        'meta_description' => 'Yeni açıklama',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->withoutVite();
        $this->actingAs(User::factory()->create());
    }

    public function test_saved_settings_appear_on_home_page(): void
    {
        $this->put(route('admin.settings.update'), $this->settings)
            ->assertRedirect(route('admin.settings.edit'))
            ->assertSessionHas('status', 'Site ayarları kaydedildi.');

        $this->get('/')
            ->assertSee('Yeni bir slogan.')
            ->assertSee('Yeni giriş metni.')
            ->assertSee('yeni@example.com');
    }

    public function test_settings_are_validated(): void
    {
        $this->put(route('admin.settings.update'), [...$this->settings, 'slogan' => '', 'contact_email' => 'gecersiz'])
            ->assertSessionHasErrors([
                'slogan' => 'Lütfen sloganı yazın.',
                'contact_email' => 'Geçerli bir e-posta adresi girin.',
            ]);
    }
}
