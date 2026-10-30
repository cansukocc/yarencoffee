<?php

namespace Tests\Feature\Admin;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessageManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        $this->actingAs(User::factory()->create());
    }

    private function message(array $overrides = []): ContactMessage
    {
        return ContactMessage::create([
            'name' => 'Ayşe',
            'email' => 'ayse@example.com',
            'message' => 'Merhaba, bilgi almak istiyorum.',
            ...$overrides,
        ]);
    }

    public function test_opening_a_message_marks_it_as_read(): void
    {
        $message = $this->message();

        $this->get(route('admin.messages.show', $message))->assertOk();

        $this->assertNotNull($message->fresh()->read_at);
    }

    public function test_listing_does_not_mark_messages_as_read(): void
    {
        $message = $this->message();

        $this->get(route('admin.messages.index'))->assertOk()->assertSee('Ayşe');
        $this->get(route('admin.dashboard'))->assertOk()->assertSee('Ayşe');

        $this->assertNull($message->fresh()->read_at);
    }

    public function test_message_content_is_escaped(): void
    {
        $message = $this->message(['message' => "<script>alert(1)</script>\nİkinci satır"]);

        $this->get(route('admin.messages.show', $message))
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false);
    }

    public function test_message_can_be_marked_as_unread(): void
    {
        $message = $this->message(['read_at' => now()]);

        $this->patch(route('admin.messages.unread', $message))
            ->assertRedirect(route('admin.messages.index'));

        $this->assertNull($message->fresh()->read_at);
    }

    public function test_message_can_be_deleted(): void
    {
        $message = $this->message();

        $this->delete(route('admin.messages.destroy', $message))
            ->assertRedirect(route('admin.messages.index'))
            ->assertSessionHas('status', 'Mesaj silindi.');

        $this->assertModelMissing($message);
    }

    public function test_unread_filter_and_badge(): void
    {
        $this->message(['name' => 'Okunmamış Kişi']);
        $this->message(['name' => 'Okunmuş Kişi', 'read_at' => now()]);

        $this->get(route('admin.messages.index', ['filtre' => 'okunmamis']))
            ->assertSee('Okunmamış Kişi')
            ->assertDontSee('Okunmuş Kişi')
            ->assertSee('data-unread-badge', false);
    }

    public function test_messages_are_paginated_newest_first(): void
    {
        foreach (range(1, 16) as $number) {
            $this->message(['name' => "Kişi {$number}"]);
        }

        $this->get(route('admin.messages.index'))
            ->assertSee('Kişi 16')
            ->assertDontSee('Kişi 1<', false)
            ->assertSee('Sayfa 1 / 2');
    }
}
