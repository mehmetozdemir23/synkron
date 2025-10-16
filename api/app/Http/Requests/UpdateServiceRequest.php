<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        $service = $this->route('service');

        return $service && $this->user()->can('update', $service);
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'duration_minutes' => ['sometimes', 'integer', 'min:1', 'max:1440'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.max' => 'Le nom du service ne peut pas dépasser 255 caractères.',
            'duration_minutes.integer' => 'La durée doit être un nombre entier.',
            'duration_minutes.min' => 'La durée doit être d\'au moins 1 minute.',
            'duration_minutes.max' => 'La durée ne peut pas dépasser 24 heures (1440 minutes).',
            'price.numeric' => 'Le prix doit être un nombre.',
            'price.min' => 'Le prix ne peut pas être négatif.',
            'price.max' => 'Le prix ne peut pas dépasser 999 999,99.',
            'is_active.boolean' => 'Le statut doit être vrai ou faux.',
        ];
    }
}
