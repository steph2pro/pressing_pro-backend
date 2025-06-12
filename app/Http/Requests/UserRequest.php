<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserRequest extends FormRequest
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
            'email'=> 'required|email',
            'profil' => 'required',
            'adresse' => 'required',
            'phone'=> 'required',
            'password'=> 'required',
        ];
    }

    //on verifie si celui qui tente de se connecte se trouve dans la table admin ou user
    public function withValidator($validator)
{
    $validator->after(function ($validator) {
        $email = $this->input('email');
        $existsInUsers = \App\Models\User::where('email', $email)->exists();
        $existsInAdmins = \App\Models\Admin::where('email', $email)->exists();
        if ($existsInUsers || $existsInAdmins) {
            $validator->errors()->add('email', 'Cette adresse mail existe déjà dans users ou admins.');
        }
    });
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
            'name.required' => 'Un nom est requis.',
            'email.required' => 'Une adresse mail est requis.',
            'email.unique' => 'Cette adresse mail existe deja .',
            'password.required' => 'Le mot de passe est requis.',
            'profil.required' => 'Le profil est requis.',
            'adresse.required' => 'L\'adresse est requise.',
            'phone.required' => 'Le numéro de téléphone est requis.',
            
        ];
    }
}
