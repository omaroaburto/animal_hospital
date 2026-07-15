<?php

namespace App\Domains\Auth\Requests;

use App\Http\Requests\ApiFormRequest;

class StoreAdminRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'first_name' => ['required','min:3', 'max:100', 'regex:/^[\p{L}\'\s\-]+$/u'],
            'last_name'  => ['required','min:3', 'max:100', 'regex:/^[\p{L}\'\s\-]+$/u'],
            'email'      => ['required', 'email','max:100', 'unique:users,email'],
            'password'   => ['required','string', 'confirmed','min:8','alpha_num','max:25'],
            'phone'      => ['required','regex:/^(?:\+56)?9\d{8}$/','digits:9'],
            'avatar'     => ['nullable','image','mimes:jpeg,png,jpg,webp','max:2048'],
        ];
    }
    public function messages(): array
    {
        return array_merge($this->commonMessages(), [
            'first_name.regex' => 'Ingrese nombres válidos.',
            'last_name.regex' => 'Ingrese apellidos válidos.',
            'phone.regex' => 'Ingrese un número de teléfono válido (9xxxxxxxx)'
        ]);
    }
}
