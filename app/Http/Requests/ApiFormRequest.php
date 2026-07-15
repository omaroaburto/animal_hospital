<?php
namespace App\Http\Requests;

use App\Http\Requests\Concerns\HasValidationAttributes;
use App\Http\Requests\Concerns\HasValidationMessages;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class ApiFormRequest extends FormRequest{
    use HasValidationMessages;
    use HasValidationAttributes;
    
    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'message'=>'Error de validación.',
            'errors'=>$validator->errors()
        ],Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}

