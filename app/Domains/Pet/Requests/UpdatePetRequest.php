<?php

namespace App\Domains\Pet\Requests;

use App\Domains\Pet\Enums\Gender;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UpdatePetRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $required = $this->isMethod('put') ? ['required'] : ['sometimes'];

        return [
            'name' => [
                ...$required,
                'string',
                'max:50',
            ],

            'client_id' => [
                ...$required,
                'integer',
                'exists:clients,id',
            ],

            'breed_id' => [
                ...$required,
                'integer',
                'exists:breeds,id',
            ],

            'gender' => [
                ...$required,
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
                Rule::unique('pets', 'microchip_number')
                    ->ignore($this->route('pet')),
                Rule::requiredIf(fn() => $this->boolean('microchip')),
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
    //transforma a boolean los datos enviados por form-data
    protected function prepareForValidation(): void
    {
        // Solo transforma y fusiona el dato SI el cliente lo envió en el request
        $this->whenHas('microchip', function ($value) {
            $this->merge([
                'microchip' => filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
            ]);
        });

        $this->whenHas('sterilized', function ($value) {
            $this->merge([
                'sterilized' => filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
            ]);
        });
    }
}
