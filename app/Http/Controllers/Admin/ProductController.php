<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use App\Services\ProductImageStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(private ProductImageStorage $images) {}

    public function index(): View
    {
        return view('admin.products.index', [
            'products' => Product::query()->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'product' => new Product(['is_active' => true, 'sort_order' => Product::query()->max('sort_order') + 1]),
        ]);
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        Product::create([
            ...$request->safe()->except('image'),
            'image' => $this->images->store($request->file('image')),
        ]);

        return redirect()->route('admin.products.index')->with('status', 'Ürün eklendi.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', ['product' => $product]);
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $previousImage = $product->image;

        $product->update([
            ...$request->safe()->except('image'),
            'image' => $request->hasFile('image') ? $this->images->store($request->file('image')) : $previousImage,
        ]);

        if ($product->image !== $previousImage) {
            $this->images->delete($previousImage);
        }

        return redirect()->route('admin.products.index')->with('status', 'Ürün güncellendi.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        $this->images->delete($product->image);

        return redirect()->route('admin.products.index')->with('status', 'Ürün silindi.');
    }
}
