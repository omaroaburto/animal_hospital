<?php

namespace App\Domains\Auth\Requests;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

class UpdateAdminRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        //$userId = $this->route('admin') ?? $this->route('user') ?? $this->user()?->id;
        $userId = $this->route('admin')?->id
            ?? $this->route('user')?->id
            ?? $this->user()?->id;
        $isPut = $this->isMethod('put');

        return [
            'first_name' => [$isPut ? 'required' : 'sometimes','min:3','string', 'max:100', 'regex:/^[\p{L}\'\s\-]+$/u'],
            'last_name'  => [$isPut ? 'required' : 'sometimes','min:3','string', 'max:100', 'regex:/^[\p{L}\'\s\-]+$/u'],
            'email'      => [
                $isPut ? 'required' : 'sometimes',
                'email',
                'max:100',
                'confirmed',
                Rule::unique('users', 'email')->ignore($userId),
                Rule::unique('users', 'pending_email'),
            ],
            'password'   => ['sometimes','required','string','min:8','alpha_num','max:25'],
            'phone'      => [$isPut ? 'required' : 'sometimes','regex:/^(?:\+56)?9\d{8}$/','digits:9'],
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
