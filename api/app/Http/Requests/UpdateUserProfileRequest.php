<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Override;

class UpdateUserProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->user());
    }

    public function rules(): array
    {
        return [
            'firstname' => ['sometimes', 'string', 'max:255'],
            'lastname' => ['sometimes', 'string', 'max:255'],
            'business_name' => ['nullable', 'string', 'max:255'],
            'activity' => ['nullable', 'string', 'max:255'],
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'firstname.max' => 'Le prénom ne peut pas dépasser 255 caractères.',
            'lastname.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'business_name.max' => 'Le nom de l\'entreprise ne peut pas dépasser 255 caractères.',
            'activity.max' => 'L\'activité ne peut pas dépasser 255 caractères.',
        ];
    }
}
