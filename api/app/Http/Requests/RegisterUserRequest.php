<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Override;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'business_name' => ['nullable', 'string', 'max:255'],
            'activity' => ['nullable', 'string', 'max:255'],
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'firstname.required' => 'Veuillez indiquer votre prénom.',
            'firstname.max' => 'Le prénom ne peut pas dépasser 255 caractères.',
            'lastname.required' => 'Veuillez indiquer votre nom.',
            'lastname.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'email.required' => 'Veuillez indiquer votre adresse email.',
            'email.email' => 'Veuillez fournir une adresse email valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'password.required' => 'Veuillez choisir un mot de passe.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'business_name.max' => 'Le nom de l\'entreprise ne peut pas dépasser 255 caractères.',
            'activity.max' => 'L\'activité ne peut pas dépasser 255 caractères.',
        ];
    }
}
