<?php

namespace App\Http\Requests; // O el namespace global que uses para cosas compartidas

class BaseIndexFilterRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'per_page'  => ['nullable', 'integer', 'min:1', 'max:100'],
            'page'      => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
            'all' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        // Campos booleanos que viajan por URL y necesitan normalización
        $booleanFilters = ['is_active', 'all'];

        foreach ($booleanFilters as $field) {
            if ($this->has($field)) {
                $this->merge([
                    $field => filter_var($this->get($field), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
                ]);
            }
        }
    }
}