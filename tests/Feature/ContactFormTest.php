<?php

namespace Tests\Feature;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Mail;
use RuntimeException;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    private array $valid = [
        'name' => 'Ayşe Yılmaz',
        'email' => 'ayse@example.com',
        'message' => 'Toptan sipariş hakkında bilgi almak istiyorum.',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        config(['yaren.contact_recipient' => 'coffee@example.com']);
    }

    public function test_valid_submission_is_saved_and_mailed(): void
    {
        Mail::fake();

        $this->postJson(route('contact.store'), $this->valid)
            ->assertOk()
            ->assertJson(['message' => 'Teşekkürler Ayşe Yılmaz! Mesajınız bize ulaştı, en kısa sürede dönüş yapacağız.']);

        $this->assertDatabaseHas('contact_messages', ['email' => 'ayse@example.com', 'read_at' => null]);

        Mail::assertSent(ContactMessageReceived::class, function (ContactMessageReceived $mail) {
            return $mail->hasTo('coffee@example.com')
                && $mail->hasReplyTo('ayse@example.com')
                && $mail->hasSubject('Yeni iletişim mesajı: Ayşe Yılmaz');
        });
    }

    public function test_mail_body_escapes_user_input(): void
    {
        $message = ContactMessage::create([...$this->valid, 'message' => '<script>alert(1)</script> merhaba']);

        (new ContactMessageReceived($message))
            ->assertDontSeeInHtml('<script>alert(1)</script>', false)
            ->assertSeeInHtml('&lt;script&gt;alert(1)&lt;/script&gt;', false);
    }

    public function test_empty_fields_return_turkish_errors(): void
    {
        $this->postJson(route('contact.store'), ['name' => '', 'email' => '', 'message' => '   '])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'name' => 'Lütfen adınızı yazın.',
                'email' => 'Geçerli bir e-posta adresi girin.',
                'message' => 'Mesajınız en az 10 karakter olmalı.',
            ]);

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_invalid_email_returns_only_email_error(): void
    {
        $this->postJson(route('contact.store'), [...$this->valid, 'email' => 'gecersiz'])
            ->assertUnprocessable()
            ->assertOnlyJsonValidationErrors(['email' => 'Geçerli bir e-posta adresi girin.']);
    }

    public function test_submission_without_javascript_redirects_with_flash(): void
    {
        Mail::fake();

        $this->post(route('contact.store'), $this->valid)
            ->assertRedirect(url('/').'#iletisim')
            ->assertSessionHas('contact_success');

        $this->assertDatabaseCount('contact_messages', 1);

        $this->get('/')
            ->assertSee('Mesajınız yolda.')
            ->assertSee('Teşekkürler Ayşe Yılmaz!');
    }

    public function test_invalid_submission_without_javascript_keeps_input(): void
    {
        $this->followingRedirects()
            ->post(route('contact.store'), [...$this->valid, 'email' => 'gecersiz'])
            ->assertOk()
            ->assertSee('Geçerli bir e-posta adresi girin.')
            ->assertSee('Formda birkaç eksik var, lütfen kontrol edin.')
            ->assertSee('value="gecersiz"', false)
            ->assertSee('Toptan sipariş hakkında bilgi almak istiyorum.');
    }

    public function test_honeypot_returns_success_without_saving_or_mailing(): void
    {
        Mail::fake();

        $this->postJson(route('contact.store'), [...$this->valid, 'website' => 'https://spam.example'])
            ->assertOk();

        $this->assertDatabaseCount('contact_messages', 0);
        Mail::assertNothingSent();
    }

    public function test_honeypot_skips_validation(): void
    {
        Mail::fake();

        $this->postJson(route('contact.store'), ['name' => 'x', 'website' => 'https://spam.example'])
            ->assertOk();

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_mail_failure_keeps_message_and_returns_success(): void
    {
        Exceptions::fake();
        Mail::shouldReceive('to')->andThrow(new RuntimeException('SMTP kapalı'));

        $this->postJson(route('contact.store'), $this->valid)->assertOk();

        $this->assertDatabaseCount('contact_messages', 1);
        Exceptions::assertReported(RuntimeException::class);
    }

    public function test_sixth_request_is_throttled(): void
    {
        Mail::fake();

        foreach (range(1, 5) as $attempt) {
            $this->postJson(route('contact.store'), $this->valid)->assertOk();
        }

        $this->postJson(route('contact.store'), $this->valid)->assertTooManyRequests();

        $this->assertDatabaseCount('contact_messages', 5);
    }
}
