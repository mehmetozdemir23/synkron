<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Veuillez indiquer votre adresse email.',
            'email.email' => 'Veuillez fournir une adresse email valide.',
            'password.required' => 'Veuillez indiquer votre mot de passe.',
        ];
    }
}
