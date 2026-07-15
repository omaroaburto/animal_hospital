<?php

namespace App\Domains\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ.,]+$/u',
                'unique:roles,name'
            ],
            'description' => [
                'nullable',
                'min:10',
                'max:255',
                'regex:/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,\s]+$/u'
            ]
        ];
    }


    public function messages(): array
    {
        return array_merge($this->commonMessages(), [
            'name.regex' => 'El nombre del rol no debe contener números ni espacios en blanco.',
            'description.regex' => 'La descripción solo puede contener letras, números, espacios, puntos y comas.',
        ]);
    }
}
