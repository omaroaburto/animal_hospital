<?php

namespace App\Domains\Auth\Requests;
 
use Illuminate\Foundation\Http\FormRequest;

class VerifyEmailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'token' => ['required',  'string']
        ];
    }
    public function messages(): array
    {
        return [
            'token.required' => 'El token es obligatorio.',
            'token.string' => 'El token tiene que ser una cadena de texto.'
        ];
    }
}
