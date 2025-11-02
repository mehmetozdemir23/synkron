<?php

namespace App\Http\Requests;

use App\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class GetBookingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', Booking::class);
    }

    public function rules(): array
    {
        return [
            'month' => ['nullable', 'integer', 'min:1', 'max:12'],
            'year' => ['nullable', 'integer', 'min:2000'],
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'month.integer' => 'Le mois doit être un nombre.',
            'month.min' => 'Le mois doit être entre 1 et 12.',
            'month.max' => 'Le mois doit être entre 1 et 12.',
            'year.integer' => 'L\'année doit être un nombre.',
            'year.min' => 'L\'année ne peut pas être antérieure à 2000.',
        ];
    }
}
