<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public const FAILED_MESSAGE = 'E-posta veya şifre hatalı.';

    public function rules(): array
    {
        return [
            'email' => 'required|string',
            'password' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => self::FAILED_MESSAGE,
            'email.string' => self::FAILED_MESSAGE,
            'password.required' => self::FAILED_MESSAGE,
            'password.string' => self::FAILED_MESSAGE,
        ];
    }
}
