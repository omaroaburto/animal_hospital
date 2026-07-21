<?php

namespace App\Domains\Pet\Requests;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

class UpdateBreedRequest extends ApiFormRequest
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
                'min:3',
                'max:120',
            ],
            'species_id' => [
                ...$required,
                'integer',
                'exists:species,id'
            ]
        ];
    }
}
