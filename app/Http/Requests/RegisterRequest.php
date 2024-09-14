<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => "İsim alanı zorunlu!",
            "name.max" => "İsim alanı en fazla 255 karakter olabilir!",
            'email.required' => "Email alanı zorunlu!",
            "email.max" => "E-posta alanı en fazla 255 karakter olabilir!",
            "email.unique" => "Bu e-posta ile oluşturulmuş bir hesap zaten var!",
            'password.required' => "Şifre alanı zorunlu!",
            "password.min" => "Şifre en az 6 karakterden oluşmalıdır!"
        ];
    }
}
