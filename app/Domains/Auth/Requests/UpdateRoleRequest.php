<?php

namespace App\Domains\Auth\Requests;

use App\Http\Requests\ApiFormRequest;

class UpdateRoleRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Buscamos el parámetro de la ruta.
        $roleParam = $this->route('role');

        // Obtenemos el ID de forma segura sin importar si viene el modelo o solo el ID/Nombre en texto
        $roleId = $roleParam instanceof \App\domains\Auth\Models\Role
            ? $roleParam->id
            : $roleParam;

        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:50',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ.,]+$/u',
                $roleId ? "unique:roles,name,{$roleId}" : "unique:roles,name"
            ],
            'description' => [
                'sometimes',
                'nullable',
                'string',
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
