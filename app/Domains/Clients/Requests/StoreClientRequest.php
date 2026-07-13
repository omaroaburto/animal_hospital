<?php

namespace App\Domains\Clients\Requests;

use App\Domains\Clients\Enums\DocumentType;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

class StoreClientRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Identificación y Cuenta
            'first_name'      => ['required', 'min:3', 'max:100', 'regex:/^[\p{L}\'\s\-]+$/u'],
            'last_name'       => ['required', 'min:3', 'max:100', 'regex:/^[\p{L}\'\s\-]+$/u'],
            'email'           => ['required', 'email', 'max:100', 'unique:users,email'],
            'password'        => ['required', 'string', 'confirmed', 'min:8', 'alpha_num', 'max:25'],

            // Contacto y Perfil
            'phone'           => ['required', 'regex:/^(?:\+56)?9\d{8}$/', 'digits:9'],
            'secondary_phone' => ['required', 'regex:/^(?:\+56)?9\d{8}$/', 'digits:9'],
            'avatar'          => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],

            // Documento de Identidad
            'document_type'   => ['required', 'string', Rule::enum(DocumentType::class)],
            'document_number' => [
                'required',
                'string',
                ...match ($this->document_type) {
                    DocumentType::RUT->value => [
                        'regex:/^\d{1,2}\.\d{3}\.\d{3}-[\dkK]$/',
                        'max:12'
                    ],
                    DocumentType::PASSPORT->value => [
                        'regex:/^[a-zA-Z0-9]+$/',
                        'max:20'
                    ],
                    default => ['max:255'],
                }
            ],

            // Dirección
            'street'          => ['required', 'string', 'max:150'],
            'number'          => ['required', 'string', 'max:20'],
            'apartment'       => ['nullable', 'string', 'max:20'],
            'commune_id'      => ['required', 'integer', 'exists:communes,id'],

            // Otros
            'notes'           => ['nullable', 'string', 'min:10', 'max:65535'],
        ];
    }

    public function messages(): array
    {
        return [
            // Nombre
            'first_name.required'      => 'Por favor, ingresa el nombre.',
            'first_name.min'           => 'El nombre debe tener al menos 3 letras.',
            'first_name.max'           => 'El nombre es demasiado largo (máximo 100 letras).',
            'first_name.regex'         => 'El nombre solo puede contener letras.',

            // Apellido
            'last_name.required'       => 'Por favor, ingresa los apellidos.',
            'last_name.min'            => 'El apellido debe tener al menos 3 letras.',
            'last_name.max'            => 'El apellido es demasiado largo (máximo 100 letras).',
            'last_name.regex'          => 'El apellido solo puede contener letras.',

            // Correo Electrónico
            'email.required'           => 'Por favor, ingresa un correo electrónico.',
            'email.email'              => 'Ingresa un correo electrónico válido (ejemplo: usuario@correo.com).',
            'email.max'                => 'El correo electrónico es demasiado largo.',
            'email.unique'             => 'Este correo electrónico ya está registrado en el sistema.',

            // Contraseña
            'password.required'        => 'Por favor, ingresa una contraseña.',
            'password.string'          => 'La contraseña no es válida.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'password.min'             => 'La contraseña debe tener al menos 8 caracteres.',
            'password.alpha_num'       => 'La contraseña debe combinar letras y números, sin símbolos especiales.',
            'password.max'             => 'La contraseña no puede tener más de 25 caracteres.',

            // Teléfono Principal
            'phone.required'           => 'Por favor, ingresa un número de teléfono.',
            'phone.regex'              => 'El formato del teléfono principal no es válido (ej: 912345678).',
            'phone.digits'             => 'El número de teléfono debe tener exactamente 9 dígitos.',

            // Teléfono Secundario
            'secondary_phone.required' => 'Por favor, ingresa un número de teléfono secundario.',
            'secondary_phone.regex'    => 'El formato del teléfono secundario no es válido (ej: 912345678).',
            'secondary_phone.digits'   => 'El teléfono secundario debe tener exactamente 9 dígitos.',

            // Avatar (Corregido de 'image' a 'avatar')
            'avatar.image'             => 'El archivo seleccionado debe ser una imagen válida.',
            'avatar.mimes'             => 'La imagen debe estar en uno de los siguientes formatos: jpeg, png, jpg o webp.',
            'avatar.max'               => 'La imagen es demasiado pesada. El tamaño máximo permitido es de 2 MB.',

            // Tipo de Documento
            'document_type.required'   => 'El tipo de documento es obligatorio.',
            'document_type.string'     => 'El tipo de documento no es válido.',
            'document_type.enum'       => 'El tipo de documento seleccionado no está permitido.',

            // Número de Documento (Validación condicional dinámica)
            'document_number.required' => 'El número de documento es obligatorio.',
            'document_number.string'   => 'El número de documento debe ser una cadena de texto.',
            'document_number.max'      => match ($this->document_type) {
                DocumentType::RUT->value      => 'El RUT no puede superar los 12 caracteres.',
                DocumentType::PASSPORT->value => 'El pasaporte no puede superar los 20 caracteres.',
                default                       => 'El número de documento es demasiado largo.',
            },
            'document_number.regex'    => match ($this->document_type) {
                DocumentType::RUT->value      => 'El formato del RUT no es válido (ej: 12.345.678-K).',
                DocumentType::PASSPORT->value => 'El pasaporte solo debe contener letras y números.',
                default                       => 'El formato del documento es inválido.',
            },

            // Dirección
            'street.required'          => 'El nombre de la calle es obligatorio.',
            'street.string'            => 'La calle debe ser un texto válido.',
            'street.max'               => 'El nombre de la calle es demasiado largo (máximo 150 caracteres).',

            'number.required'          => 'El número de la dirección es obligatorio.',
            'number.string'            => 'El número de la dirección no es válido.',
            'number.max'               => 'El número de la dirección es demasiado largo (máximo 20 caracteres).',

            'apartment.string'         => 'El departamento/oficina debe ser un texto válido.',
            'apartment.max'            => 'El campo departamento/oficina no puede superar los 20 caracteres.',

            'commune_id.required'      => 'La comuna es obligatoria.',
            'commune_id.integer'       => 'La comuna seleccionada no es válida.',
            'commune_id.exists'        => 'La comuna seleccionada no está registrada en el sistema.',

            // Notas
            'notes.string'             => 'Las notas deben ser un texto válido.',
            'notes.min'                => 'Las notas deben contener al menos 10 caracteres.',
            'notes.max'                => 'Las notas han superado el tamaño máximo de caracteres permitido.',
        ];
    }
}
