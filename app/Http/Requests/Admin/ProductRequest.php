<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:120',
            'note' => 'required|string|max:120',
            'description' => 'required|string|max:1000',
            'price' => 'required|integer|min:0|max:1000000',
            'image' => [$this->route('product') ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'image_alt' => 'required|string|max:255',
            'sort_order' => 'required|integer|min:0|max:100000',
            'is_active' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Lütfen ürün adını yazın.',
            'name.max' => 'Ürün adı en fazla 120 karakter olabilir.',
            'note.required' => 'Lütfen ürün notunu yazın.',
            'note.max' => 'Ürün notu en fazla 120 karakter olabilir.',
            'description.required' => 'Lütfen açıklamayı yazın.',
            'description.max' => 'Açıklama en fazla 1000 karakter olabilir.',
            'price.required' => 'Lütfen fiyatı yazın.',
            'price.integer' => 'Fiyat tam sayı olmalı.',
            'price.min' => 'Fiyat sıfırdan küçük olamaz.',
            'price.max' => 'Fiyat çok yüksek.',
            'image.required' => 'Lütfen bir görsel seçin.',
            'image.image' => 'Görsel jpg, png veya webp olmalı.',
            'image.mimes' => 'Görsel jpg, png veya webp olmalı.',
            'image.max' => 'Görsel en fazla 2 MB olabilir.',
            'image.uploaded' => 'Görsel yüklenemedi, dosya boyutunu kontrol edin.',
            'image_alt.required' => 'Lütfen görsel alt metnini yazın.',
            'image_alt.max' => 'Görsel alt metni en fazla 255 karakter olabilir.',
            'sort_order.required' => 'Lütfen sıra numarasını yazın.',
            'sort_order.integer' => 'Sıra tam sayı olmalı.',
            'sort_order.min' => 'Sıra sıfırdan küçük olamaz.',
            'sort_order.max' => 'Sıra numarası çok yüksek.',
        ];
    }
}
