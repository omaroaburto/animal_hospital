<?php

namespace App\Domains\Pet\Requests;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

class UpdateSpeciesRequest extends ApiFormRequest
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
                'min:2',
                'max:100',
            ],

            'scientific_name' => [
                ...$required,
                'string',
                'min:3',
                'max:150',
                Rule::unique('species', 'scientific_name')
                    ->ignore($this->route('species')),
            ],
        ];
    }
}
