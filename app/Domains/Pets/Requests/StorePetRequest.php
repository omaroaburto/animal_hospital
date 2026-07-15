<?php

namespace App\Domains\Pets\Requests;

use App\Domains\Pets\Enums\Gender;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class StorePetRequest extends ApiFormRequest
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
            ],

            'client_id' => [
                'required',
                'integer',
                'exists:clients,id',
            ],

            'breed_id' => [
                'required',
                'integer',
                'exists:breeds,id',
            ],

            'gender' => [
                'required',
                'string',
                Rule::enum(Gender::class),
            ],

            'microchip' => [
                'sometimes',
                'boolean',
            ],

            'microchip_number' => [
                'nullable',
                'string',
                'max:15',
                'unique:pets,microchip_number',
                'required_if:microchip,true',
            ],

            'birth_date' => [
                'nullable',
                'date',
                'before_or_equal:today',
            ],

            'death_date' => [
                'nullable',
                'date',
                'before_or_equal:today',
                'after_or_equal:birth_date',
            ],

            'color' => [
                'nullable',
                'string',
                'max:255',
            ],

            'sterilized' => [
                'sometimes',
                'boolean',
            ],

            'photo' => [
                'nullable',
                File::image()
                    ->types(['jpeg', 'jpg', 'png', 'webp'])
                    ->max(2048),
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ];
    }
}
