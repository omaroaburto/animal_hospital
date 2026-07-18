<?php

namespace App\Domains\Pets\Requests;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

class DeleteBreedRequest extends ApiFormRequest
{
    public function authorize(): bool 
    { 
        return true; 
    }
    
    public function rules(): array
    { 
        $breed = $this->route('breed');

        $rules = [];

        if ($breed->pets()->exists()) {
            $rules['replacement_breed_id'] = [
                'required',
                'integer',
                Rule::exists('breeds', 'id'),
            ];
        }

        return $rules;
    }
}