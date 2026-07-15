<?php

namespace App\Domains\Pets\Requests;

use App\Http\Requests\ApiFormRequest;

class StoreBreedRequest extends ApiFormRequest
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
                'min:3',
                'max:120',
            ],
            'species_id' => [
                'required',
                'integer',
                'exists:species,id'
            ]
        ];
    }
}
