<?php

namespace App\domains\Auth\Requests;

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
        return [
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.string' => 'Ingresa un formato válido para el nombre del rol.',
            'name.max' => 'El nombre del rol no puede tener más de 50 letras.',
            'name.regex' => 'El nombre del rol no debe contener números ni espacios en blanco.',
            'name.unique' => 'No puede ingresar un nombre de rolque está registrado.',

            //descripción
            'description.min' => 'La descripción del rol debe tener al menos 10 caracteres si decide completarla.',
            'description.max' => 'La descripción del rol debe tener como máximo 255 caracteres si decide completarla.',
            'description.regex' => 'La descripción solo puede contener letras, números, espacios, puntos y comas.',
        ];
    }
}
