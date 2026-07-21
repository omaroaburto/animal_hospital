<?php

namespace App\Domains\Pet\Requests;

use App\Http\Requests\ApiFormRequest;

class StoreSpeciesRequest extends ApiFormRequest
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
                'min:2',
                'max:100'
            ],

            'scientific_name' => [
                'required',
                'unique:species,scientific_name',
                'string',
                'min:3',
                'max:150'
            ],
        ];
    }
}
