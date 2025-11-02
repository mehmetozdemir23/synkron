<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class GetAvailableSlotsRequest extends FormRequest
{
    public function authorize(): bool
    {

        return true;
    }

    public function rules(): array
    {
        return [
            'start_date' => ['nullable', 'date', 'after_or_equal:today'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'start_date.date' => 'Le format de la date de début est invalide. Utilisez le format ISO 8601 (ex: 2025-01-15).',
            'start_date.after_or_equal' => 'La date de début doit être aujourd\'hui ou dans le futur.',
            'end_date.date' => 'Le format de la date de fin est invalide. Utilisez le format ISO 8601 (ex: 2025-01-15).',
            'end_date.after_or_equal' => 'La date de fin doit être après ou égale à la date de début.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            $startDate = $this->input('start_date')
                ? Carbon::parse($this->input('start_date'))
                : Carbon::now();

            $endDate = $this->input('end_date')
                ? Carbon::parse($this->input('end_date'))
                : Carbon::now()->addDays(30);

            if ($startDate->diffInDays($endDate) > 90) {
                $validator->errors()->add('end_date', 'La plage de dates ne peut pas dépasser 90 jours.');
            }
        });
    }
}
