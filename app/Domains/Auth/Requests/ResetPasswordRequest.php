<?php

namespace App\Domains\Auth\Requests;

use App\Http\Requests\ApiFormRequest;

class ResetPasswordRequest extends ApiFormRequest
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
            ],

            'token' => [
                'required',
                'string',
            ],

            'password' => [
                'required',
                'string',
                'confirmed',
                'min:8',
                'alpha_num',
                'max:25'
            ],
        ];
    }
    public function messages(): array
    {
        return [
            //email
            'email.required'      => 'Por favor, ingresa un correo electrónico.',
            'email.email'         => 'Ingresa un correo electrónico válido (ejemplo: usuario@correo.com).',
            'email.max'           => 'El correo electrónico es demasiado largo.',

            //token
            'token.required'      => 'Ingrese el token.',
            'token.string'      => 'Ingrese un token válido.',

            // Contraseña
            'password.required'   => 'Por favor, ingresa una contraseña.',
            'password.string'     => 'La contraseña no es válida.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'password.min'        => 'La contraseña debe tener al menos 8 caracteres.',
            'password.alpha_num'  => 'La contraseña debe combinar letras y números, sin símbolos especiales.',
            'password.max'        => 'La contraseña no puede tener más de 25 caracteres.',
        ];
    }
}
