<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public static function protectedPages(): array
    {
        return [['/yonetim'], ['/yonetim/urunler'], ['/yonetim/ayarlar'], ['/yonetim/mesajlar']];
    }

    #[DataProvider('protectedPages')]
    public function test_guests_are_redirected_to_login(string $path): void
    {
        $this->get($path)->assertRedirect(route('admin.login'));
    }

    public function test_correct_credentials_log_in(): void
    {
        $user = User::factory()->create(['password' => 'dogru-sifre']);

        $this->post(route('admin.login.store'), ['email' => $user->email, 'password' => 'dogru-sifre'])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_wrong_credentials_show_single_message(): void
    {
        $user = User::factory()->create(['password' => 'dogru-sifre']);

        $this->from(route('admin.login'))
            ->post(route('admin.login.store'), ['email' => $user->email, 'password' => 'yanlis'])
            ->assertRedirect(route('admin.login'))
            ->assertSessionHasErrors(['email' => 'E-posta veya şifre hatalı.']);

        $this->assertGuest();
    }

    public function test_login_page_is_not_indexed(): void
    {
        $this->get(route('admin.login'))->assertSee('<meta name="robots" content="noindex">', false);
    }

    public function test_logout_ends_the_session(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('admin.logout'))
            ->assertRedirect(route('admin.login'));

        $this->assertGuest();
    }

    public function test_login_is_throttled(): void
    {
        foreach (range(1, 5) as $attempt) {
            $this->post(route('admin.login.store'), ['email' => 'a@b.co', 'password' => 'yanlis'])->assertRedirect();
        }

        $this->post(route('admin.login.store'), ['email' => 'a@b.co', 'password' => 'yanlis'])->assertTooManyRequests();
    }

    public function test_admin_seeder_creates_user(): void
    {
        config(['yaren.admin' => ['name' => 'Admin', 'email' => 'admin@example.com', 'password' => 'ilk-sifre']]);

        $this->seed(AdminUserSeeder::class);

        $this->assertTrue(Hash::check('ilk-sifre', User::firstWhere('email', 'admin@example.com')->password));
    }

    public function test_admin_seeder_keeps_existing_password(): void
    {
        config(['yaren.admin' => ['name' => 'Admin', 'email' => 'admin@example.com', 'password' => 'ilk-sifre']]);
        $this->seed(AdminUserSeeder::class);

        config(['yaren.admin.password' => 'baska-sifre']);
        $this->seed(AdminUserSeeder::class);

        $this->assertSame(1, User::count());
        $this->assertTrue(Hash::check('ilk-sifre', User::first()->password));
    }

    public function test_admin_seeder_skips_without_credentials(): void
    {
        config(['yaren.admin' => ['name' => null, 'email' => null, 'password' => null]]);

        $this->seed(AdminUserSeeder::class);

        $this->assertSame(0, User::count());
    }
}
