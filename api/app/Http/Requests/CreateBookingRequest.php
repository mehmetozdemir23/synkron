<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_name' => ['required', 'string', 'max:255'],
            'client_email' => ['required', 'string', 'email', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'start_at' => ['required', 'date', 'after:now'],
        ];
    }

    public function messages(): array
    {
        return [
            'client_name.required' => 'Veuillez indiquer votre nom.',
            'client_name.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'client_email.required' => 'Veuillez indiquer votre adresse email.',
            'client_email.email' => 'Veuillez fournir une adresse email valide.',
            'client_email.max' => 'L\'adresse email ne peut pas dépasser 255 caractères.',
            'start_at.required' => 'Veuillez sélectionner un créneau horaire.',
            'start_at.date' => 'Le format de la date est invalide.',
            'start_at.after' => 'Le créneau doit être dans le futur.',
        ];
    }
}
