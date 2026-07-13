<?php

namespace App\Domains\Auth\Requests;

use App\Http\Requests\ApiFormRequest;

class StoreAdminRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'first_name' => ['required','min:3', 'max:100', 'regex:/^[\p{L}\'\s\-]+$/u'],
            'last_name'  => ['required','min:3', 'max:100', 'regex:/^[\p{L}\'\s\-]+$/u'],
            'email'      => ['required', 'email','max:100', 'unique:users,email'],
            'password'   => ['required','string', 'confirmed','min:8','alpha_num','max:25'],
            'phone'      => ['required','regex:/^(?:\+56)?9\d{8}$/','digits:9'],
            'avatar'     => ['nullable','image','mimes:jpeg,png,jpg,webp','max:2048'],
        ];
    }
    public function messages(): array
    {
        return [
            // Nombre
            'first_name.required' => 'Por favor, ingresa el nombre.',
            'first_name.min'      => 'El nombre debe tener al menos 3 letras.',
            'first_name.max'      => 'El nombre es demasiado largo (máximo 100 letras).',
            'first_name.regex'    => 'El nombre solo puede contener letras.',

            // Apellido
            'last_name.required'  => 'Por favor, ingresa los apellidos.',
            'last_name.min'       => 'El apellido debe tener al menos 3 letras.',
            'last_name.max'       => 'El apellido es demasiado largo (máximo 100 letras).', // Corregido de 3 a 100
            'last_name.regex'     => 'El apellido solo puede contener letras.',

            // Correo Electrónico
            'email.required'      => 'Por favor, ingresa un correo electrónico.',
            'email.email'         => 'Ingresa un correo electrónico válido (ejemplo: usuario@correo.com).',
            'email.max'           => 'El correo electrónico es demasiado largo.',
            'email.unique'        => 'Este correo electrónico ya está registrado en el sistema.',

            // Contraseña
            'password.required'   => 'Por favor, ingresa una contraseña.',
            'password.string'     => 'La contraseña no es válida.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'password.min'        => 'La contraseña debe tener al menos 8 caracteres.',
            'password.alpha_num'  => 'La contraseña debe combinar letras y números, sin símbolos especiales.',
            'password.max'        => 'La contraseña no puede tener más de 25 caracteres.',

            // Teléfono
            'phone.required'      => 'Por favor, ingresa un número de teléfono.',
            'phone.regex'         => 'El formato del teléfono no es válido.',
            'phone.digits'        => 'El número de teléfono debe tener exactamente 9 dígitos.',

             //avatar
            'avatar.image' => 'El archivo seleccionado debe ser una imagen válida.',
            'avatar.mimes' => 'La imagen debe estar en uno de los siguientes formatos: jpeg, png, jpg o webp.',
            'avatar.max'   => 'La imagen es demasiado pesada. El tamaño máximo permitido es de 2 MB.',
        ];
    }
}
