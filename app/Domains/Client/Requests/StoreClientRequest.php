<?php

namespace App\Domains\Client\Requests;

use App\Domains\Client\Enums\DocumentType;
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
                'unique:clients,document_number',
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
        return array_merge($this->commonMessages(), [
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
        ]);
    }
}
