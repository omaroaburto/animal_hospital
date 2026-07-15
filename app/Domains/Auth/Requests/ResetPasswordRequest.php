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
}
