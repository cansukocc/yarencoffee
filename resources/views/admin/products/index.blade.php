@extends('admin.layouts.app')

@section('title', 'Ürünler')

@section('actions')
    <x-admin.button :href="route('admin.products.create')">
        <x-icon name="plus" class="size-4" />
        Ürün Ekle
    </x-admin.button>
@endsection

@section('content')
    <table class="block w-full md:table">
        <thead class="hidden text-left text-xs uppercase tracking-[0.15em] text-muted-foreground md:table-header-group">
            <tr>
                <th scope="col" class="px-4 py-3 font-semibold">Ürün</th>
                <th scope="col" class="px-4 py-3 font-semibold">Fiyat</th>
                <th scope="col" class="px-4 py-3 font-semibold">Sıra</th>
                <th scope="col" class="px-4 py-3 font-semibold">Durum</th>
                <th scope="col" class="px-4 py-3"><span class="sr-only">İşlemler</span></th>
            </tr>
        </thead>
        <tbody class="block space-y-3 md:table-row-group md:space-y-0">
            @forelse ($products as $product)
                <tr class="block rounded-2xl bg-card p-4 md:table-row md:rounded-none md:border-t md:border-border md:p-0" data-product-row>
                    <td class="block md:table-cell md:px-4 md:py-3">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->image_alt }}" width="64" height="64" loading="lazy" class="size-16 shrink-0 rounded-xl object-cover">
                            <div class="min-w-0">
                                <p class="truncate font-serif text-xl text-coffee">{{ $product->name }}</p>
                                <p class="truncate text-sm text-muted-foreground">{{ $product->note }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="mt-3 inline-block pr-4 font-semibold text-coffee md:mt-0 md:table-cell md:px-4 md:py-3">₺{{ $product->price }}</td>
                    <td class="inline-block pr-4 text-sm text-muted-foreground md:table-cell md:px-4 md:py-3">
                        <span class="md:hidden">Sıra:</span> {{ $product->sort_order }}
                    </td>
                    <td class="inline-block md:table-cell md:px-4 md:py-3">
                        <span @class([
                            'rounded-full px-2.5 py-1 text-xs font-medium',
                            'bg-olive/15 text-olive' => $product->is_active,
                            'bg-muted text-muted-foreground' => ! $product->is_active,
                        ])>{{ $product->is_active ? 'Aktif' : 'Pasif' }}</span>
                    </td>
                    <td class="mt-4 block md:mt-0 md:table-cell md:px-4 md:py-3">
                        <div class="flex gap-2 md:justify-end">
                            <x-admin.button variant="secondary" :href="route('admin.products.edit', $product)">Düzenle</x-admin.button>
                            <x-admin.delete-form :action="route('admin.products.destroy', $product)" :confirm="$product->name.' silinsin mi?'" />
                        </div>
                    </td>
                </tr>
            @empty
                <tr class="block md:table-row">
                    <td colspan="5" class="block py-6 text-muted-foreground md:table-cell">Henüz ürün yok.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
