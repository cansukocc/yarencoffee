<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-5 rounded-[2rem] bg-card p-6 md:p-8">
    @csrf
    @isset($method)
        @method($method)
    @endisset

    <div class="grid gap-5 md:grid-cols-2">
        <x-admin.field label="Ad" name="name" :value="$product->name" maxlength="120" required />
        <x-admin.field label="Not" name="note" :value="$product->note" maxlength="120" required />
    </div>

    <x-admin.field label="Açıklama" name="description" :value="$product->description" maxlength="1000" textarea required />

    <div class="grid gap-5 md:grid-cols-2">
        <x-admin.field label="Fiyat (₺)" name="price" type="number" min="0" :value="$product->price" required />
        <x-admin.field label="Sıra" name="sort_order" type="number" min="0" :value="$product->sort_order" required />
    </div>

    <div>
        <label for="field-image" class="mb-2 block text-sm font-semibold text-coffee">Görsel</label>
        <img
            src="{{ $product->image ? asset($product->image) : '' }}"
            alt=""
            class="mb-3 h-40 w-full max-w-xs rounded-xl object-cover"
            data-image-preview
            @unless ($product->image) hidden @endunless
        >
        <input
            id="field-image"
            name="image"
            type="file"
            accept="image/jpeg,image/png,image/webp"
            class="block w-full text-sm text-coffee file:mr-4 file:cursor-pointer file:rounded-full file:border-0 file:bg-secondary file:px-4 file:py-2 file:text-sm file:font-semibold file:text-coffee"
            data-image-input
            @error('image') aria-invalid="true" aria-describedby="field-image-error" @enderror
            @unless ($product->exists) required @endunless
        >
        <p class="mt-2 text-xs text-muted-foreground">
            JPG, PNG veya WebP, en fazla 2 MB.{{ $product->exists ? ' Değiştirmek istemiyorsanız boş bırakın.' : '' }}
        </p>
        <x-admin.field-error id="field-image-error" :message="$errors->first('image')" />
    </div>

    <x-admin.field label="Görsel alt metni" name="image_alt" :value="$product->image_alt" maxlength="255" required />

    <div class="flex items-center gap-3">
        <input type="hidden" name="is_active" value="0">
        <input id="field-is-active" name="is_active" type="checkbox" value="1" class="size-5 rounded accent-olive" @checked(old('is_active', $product->is_active))>
        <label for="field-is-active" class="text-sm font-semibold text-coffee">Aktif (sitede görünsün)</label>
    </div>

    <div class="flex flex-wrap gap-3 pt-2">
        <x-admin.button>Kaydet</x-admin.button>
        <x-admin.button variant="secondary" :href="route('admin.products.index')">Vazgeç</x-admin.button>
    </div>
</form>
