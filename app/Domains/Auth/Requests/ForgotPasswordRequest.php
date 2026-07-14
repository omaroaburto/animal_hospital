<?php

namespace App\Domains\Auth\Requests;

use App\Http\Requests\ApiFormRequest;

class ForgotPasswordRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:100'],
        ];
    }
    public function messages(): array
    {
        return [
            'email.required'      => 'Por favor, ingresa un correo electrónico.',
            'email.email'         => 'Ingresa un correo electrónico válido (ejemplo: usuario@correo.com).',
            'email.max'           => 'El correo electrónico es demasiado largo.',
        ];
    }
}
