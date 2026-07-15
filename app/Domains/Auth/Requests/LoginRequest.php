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
}
