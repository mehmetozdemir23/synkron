<?php

namespace App\Http\Requests;

use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class CreateServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Service::class);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'duration_minutes' => ['required', 'integer', 'min:1', 'max:1440'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'name.required' => 'Veuillez indiquer le nom du service.',
            'name.max' => 'Le nom du service ne peut pas dépasser 255 caractères.',
            'duration_minutes.required' => 'Veuillez indiquer la durée du service.',
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
