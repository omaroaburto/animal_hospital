<?php

namespace App\Http\Requests\Concerns;

trait HasValidationAttributes
{
    public function attributes(): array
    {
        return [
            //datos de usuario y cliente
            'first_name' => 'nombres',
            'last_name' => 'apellidos',
            'avatar' => 'avatar',
            'secondary_phone' => 'teléfono secundario',
            'phone' => 'telefóno',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
            'document_type' =>'tipo de documento',
            'document_number' => 'número de identificación (rut/pasaporte)',
            'street'  => 'calle',
            'number'  => 'número de casa',
            'apartment' => 'número de apartamento',
            'notes' => 'anotaciones',//también lo usa pet
            //id modelos
            'client_id' => 'cliente',
            'breed_id' => 'raza',
            'commune_id' => 'comuna',
            'region_id' => 'region',
            'species_id' => 'especie',
            //pets, roles,species, etc
            'name' => 'nombre',
            'birth_date' => 'fecha de nacimiento',
            'death_date' => 'fecha de fallecimiento',
            'microchip_number' => 'número de microchip',
            'photo' => 'fotografía',
            'description' => 'descripción',
            'scientific_name' => 'nombre científico',
        ];
    }
}
