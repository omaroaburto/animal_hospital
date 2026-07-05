<?php

namespace App\Domains\Auth\Requests;

use App\Http\Requests\ApiFormRequest;

class LoginRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                'max:100'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'alpha_num',
                'max:25'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            //email
            'email.required' => 'El correo electrónico es un campo obligatorio.',
            'email.email'    => 'Por favor, ingresa una dirección de correo electrónico válida.',
            'email.max'      => 'El correo electrónico no puede tener más de 100 caracteres.',
            //password
            'password.required'  => 'La contraseña es un campo obligatorio.',
            'password.string'    => 'Por favor, ingresa un formato de texto válido para la contraseña.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.alpha_num' => 'Por favor, escribe la contraseña usando solo letras y números sin caracteres especiales.',
            'password.max' => 'La contraseña no puede tener más de 25 caracteres.'
        ];
    }
}
