<?php

namespace App\Http\Requests\Concerns;

trait HasValidationMessages
{
    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',

            'string' => 'El campo :attribute debe ser texto.',

            'max' => [
                'string' => 'El campo :attribute no puede superar los :max caracteres.',
                'file' => 'El archivo :attribute no puede superar los :max kilobytes.',
            ],

            'min' => [
                'string' => 'El campo :attribute no puede tener menos :min caracteres.',
                'file' => 'El archivo :attribute no puede tener menos :min kilobytes.',
            ],

            'alpha_num' => 'La :attribute solo permite letras y números sin caracteres especiales',

            'email' => 'Ingrese un correo con un formato válido (correo@correo.cl).',

            'integer' => 'El campo :attribute debe ser un número entero.',

            'exists' => 'El :attribute seleccionado no existe.',

            'unique' => 'El :attribute ya está registrado.',

            'boolean' => 'El campo :attribute debe ser verdadero o falso.',

            'date' => 'El campo :attribute debe ser una fecha válida.',

            'before_or_equal' => 'El campo :attribute debe ser una fecha anterior o igual a :date.',

            'after_or_equal' => 'El campo :attribute debe ser una fecha posterior o igual a :date.',

            'url' => 'El campo :attribute debe contener una URL válida.',

            'file' => 'El campo :attribute debe ser un archivo válido.',

            'image' => 'El archivo :attribute debe ser una imagen.',

            'mimes' => 'El archivo :attribute debe ser de tipo: :values.',

            'required_if' => 'El campo :attribute es obligatorio cuando :other es :value.',

            'confirmed' => 'La confirmación del campo :attribute no coincide.',

            'digits' => 'El campo :attribute debe tener exactamente :digits dígitos.',

            'enum' => 'El valor seleccionado para :attribute no es válido.'
        ];
    }
}
