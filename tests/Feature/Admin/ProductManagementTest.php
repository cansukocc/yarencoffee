<?php

namespace Tests\Feature\Admin;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    private string $publicPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->withoutVite();
        $this->actingAs(User::factory()->create());

        $this->publicPath = sys_get_temp_dir().'/yaren-test-'.uniqid();
        File::ensureDirectoryExists($this->publicPath);
        $this->app->usePublicPath($this->publicPath);
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->publicPath);

        parent::tearDown();
    }

    private function payload(array $overrides = []): array
    {
        return [
            'name' => 'Soğuk Demleme',
            'note' => 'Buzlu',
            'description' => 'On iki saat soğukta demlenir.',
            'price' => 130,
            'image' => UploadedFile::fake()->image('kahve.png', 2000, 1000),
            'image_alt' => 'Bardakta soğuk kahve',
            'sort_order' => 4,
            'is_active' => '1',
            ...$overrides,
        ];
    }

    private function uploadedProduct(): Product
    {
        $this->post(route('admin.products.store'), $this->payload());

        return Product::firstWhere('name', 'Soğuk Demleme');
    }

    public function test_product_can_be_created_with_resized_webp(): void
    {
        $this->post(route('admin.products.store'), $this->payload())
            ->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('status', 'Ürün eklendi.');

        $product = Product::firstWhere('name', 'Soğuk Demleme');

        $this->assertStringStartsWith('uploads/products/', $product->image);
        $this->assertStringEndsWith('.webp', $product->image);

        [$width, , $type] = getimagesize(public_path($product->image));

        $this->assertSame(1400, $width);
        $this->assertSame(IMAGETYPE_WEBP, $type);

        $this->get('/')->assertSee('Soğuk Demleme')->assertSee('₺130');
    }

    public function test_image_is_required_when_creating(): void
    {
        $this->post(route('admin.products.store'), $this->payload(['image' => null]))
            ->assertSessionHasErrors(['image' => 'Lütfen bir görsel seçin.']);
    }

    public function test_image_type_and_size_are_validated(): void
    {
        $this->post(route('admin.products.store'), $this->payload(['image' => UploadedFile::fake()->create('a.pdf', 10, 'application/pdf')]))
            ->assertSessionHasErrors(['image' => 'Görsel jpg, png veya webp olmalı.']);

        $this->post(route('admin.products.store'), $this->payload(['image' => UploadedFile::fake()->image('b.png')->size(3000)]))
            ->assertSessionHasErrors(['image' => 'Görsel en fazla 2 MB olabilir.']);
    }

    public function test_product_can_be_updated_without_new_image(): void
    {
        $product = Product::firstWhere('name', 'Espresso');

        $this->put(route('admin.products.update', $product), $this->payload(['name' => 'Doppio', 'image' => null]))
            ->assertRedirect(route('admin.products.index'));

        $this->assertSame('Doppio', $product->fresh()->name);
        $this->assertSame('images/espresso.webp', $product->fresh()->image);
    }

    public function test_replacing_uploaded_image_deletes_old_file(): void
    {
        $product = $this->uploadedProduct();
        $oldImage = $product->image;

        $this->put(route('admin.products.update', $product), $this->payload());

        $this->assertFileDoesNotExist(public_path($oldImage));
        $this->assertFileExists(public_path($product->fresh()->image));
    }

    public function test_replacing_original_image_keeps_the_file(): void
    {
        File::ensureDirectoryExists(public_path('images'));
        File::put(public_path('images/espresso.webp'), 'orijinal');

        $this->put(route('admin.products.update', Product::firstWhere('name', 'Espresso')), $this->payload());

        $this->assertFileExists(public_path('images/espresso.webp'));
    }

    public function test_deleting_product_removes_uploaded_file(): void
    {
        $product = $this->uploadedProduct();

        $this->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('status', 'Ürün silindi.');

        $this->assertModelMissing($product);
        $this->assertFileDoesNotExist(public_path($product->image));
    }

    public function test_deleting_product_keeps_original_image(): void
    {
        File::ensureDirectoryExists(public_path('images'));
        File::put(public_path('images/espresso.webp'), 'orijinal');

        $this->delete(route('admin.products.destroy', Product::firstWhere('name', 'Espresso')));

        $this->assertFileExists(public_path('images/espresso.webp'));
    }

    public function test_inactive_product_is_hidden_on_home_page(): void
    {
        $product = Product::firstWhere('name', 'Espresso');

        $this->put(route('admin.products.update', $product), [
            ...$this->payload(['name' => 'Espresso', 'price' => 95, 'image' => null]),
            'is_active' => '0',
        ]);

        $this->get('/')->assertDontSee('₺95');
    }
}
