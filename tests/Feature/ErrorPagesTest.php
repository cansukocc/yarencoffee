<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use RuntimeException;
use Tests\TestCase;

class ErrorPagesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        config(['app.debug' => false]);
    }

    public function test_missing_page_shows_turkish_404(): void
    {
        $this->get('/olmayan-sayfa')
            ->assertNotFound()
            ->assertSee('Bu fincan boş çıktı')
            ->assertSee('Ana sayfaya dön')
            ->assertSee('<html lang="tr">', false);
    }

    public function test_server_error_shows_turkish_500(): void
    {
        Route::get('/hata-testi', fn () => throw new RuntimeException('Beklenmeyen hata'));

        $this->get('/hata-testi')
            ->assertInternalServerError()
            ->assertSee('Bir şeyler ters gitti')
            ->assertDontSee('Beklenmeyen hata');
    }

    public function test_expired_session_shows_turkish_419(): void
    {
        Route::get('/oturum-testi', fn () => abort(419));

        $this->get('/oturum-testi')->assertStatus(419)->assertSee('Oturum süreniz doldu');
    }

    public function test_too_many_requests_shows_turkish_429(): void
    {
        Route::get('/limit-testi', fn () => abort(429));

        $this->get('/limit-testi')->assertTooManyRequests()->assertSee('Biraz yavaşlayalım');
    }
}
