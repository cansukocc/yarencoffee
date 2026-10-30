<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'slogan' => 'required|string|max:255',
            'hero_subtitle' => 'required|string|max:500',
            'hero_badge' => 'required|string|max:120',
            'contact_address' => 'required|string|max:255',
            'contact_email' => 'required|email:rfc|max:200',
            'contact_phone' => 'required|string|max:60',
        ];
    }

    public function messages(): array
    {
        return [
            'slogan.required' => 'Lütfen sloganı yazın.',
            'slogan.max' => 'Slogan en fazla 255 karakter olabilir.',
            'hero_subtitle.required' => 'Lütfen giriş metnini yazın.',
            'hero_subtitle.max' => 'Giriş metni en fazla 500 karakter olabilir.',
            'hero_badge.required' => 'Lütfen rozet metnini yazın.',
            'hero_badge.max' => 'Rozet metni en fazla 120 karakter olabilir.',
            'contact_address.required' => 'Lütfen adresi yazın.',
            'contact_address.max' => 'Adres en fazla 255 karakter olabilir.',
            'contact_email.required' => 'Lütfen e-posta adresini yazın.',
            'contact_email.email' => 'Geçerli bir e-posta adresi girin.',
            'contact_email.max' => 'E-posta en fazla 200 karakter olabilir.',
            'contact_phone.required' => 'Lütfen telefon numarasını yazın.',
            'contact_phone.max' => 'Telefon en fazla 60 karakter olabilir.',
        ];
    }
}
