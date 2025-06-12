<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class VetementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "quantite"=> "required",
            "p_u"=> "required",
            "depot_id"=> "required",
        ];
    }

            public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'error' => true,
            'status_code' => 422,
            'message' => 'Enregistrement vetement echoué',
            'errorsList' => $validator->errors(),
        ], 422));
    }
    
    public function messages()
    {
        return [
            'quantite.required' => 'La quantite de vetement est requise.',
            'p_u.required' => 'Le prix unitaire est requis.',
            'depot_id.required'=> 'identifient du depot requis',
            
        ];
    }
}
