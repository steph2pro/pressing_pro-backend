<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ClientRequest extends FormRequest
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
             'name' => 'required',
             'phone'=> 'required',
           
        ];
    }

         public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'error' => true,
            'status_code' => 422,
            'message' => 'Enregistrement echoué',
            'errorsList' => $validator->errors(),
        ], 422));
    }
    
    public function messages()
    {
        return [
            'name.required' => 'Un nom du client est requis.',
            'phone.required' => 'Le numéro de téléphone du client est requis.',
            
        ];
    }
}
