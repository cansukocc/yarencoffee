<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactMessageRequest extends FormRequest
{
    public function rules(): array
    {
        if ($this->isSpam()) {
            return [];
        }

        return [
            'name' => 'required|string|min:2|max:120',
            'email' => 'required|email:rfc|max:200',
            'message' => 'required|string|min:10|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Lütfen adınızı yazın.',
            'name.string' => 'Lütfen adınızı yazın.',
            'name.min' => 'Lütfen adınızı yazın.',
            'name.max' => 'Adınız en fazla 120 karakter olabilir.',
            'email.required' => 'Geçerli bir e-posta adresi girin.',
            'email.email' => 'Geçerli bir e-posta adresi girin.',
            'email.max' => 'Geçerli bir e-posta adresi girin.',
            'message.required' => 'Mesajınız en az 10 karakter olmalı.',
            'message.string' => 'Mesajınız en az 10 karakter olmalı.',
            'message.min' => 'Mesajınız en az 10 karakter olmalı.',
            'message.max' => 'Mesajınız en fazla 2000 karakter olabilir.',
        ];
    }

    public function isSpam(): bool
    {
        return $this->filled('website');
    }

    protected function getRedirectUrl(): string
    {
        return url('/').'#iletisim';
    }
}
