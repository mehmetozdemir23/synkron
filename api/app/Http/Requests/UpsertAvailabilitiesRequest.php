<?php

namespace App\Http\Requests;

use App\Models\Availability;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class UpsertAvailabilitiesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Availability::class);
    }

    public function rules(): array
    {
        return [
            'availabilities' => ['required', 'array', 'min:1'],
            'availabilities.*.day_of_week' => ['required', 'integer', 'between:0,6'],
            'availabilities.*.start_time' => ['required', 'date_format:H:i'],
            'availabilities.*.end_time' => ['required', 'date_format:H:i', 'after:availabilities.*.start_time'],
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'availabilities.required' => 'Veuillez définir au moins une plage de disponibilité.',
            'availabilities.array' => 'Les disponibilités doivent être au format tableau.',
            'availabilities.min' => 'Veuillez définir au moins une plage de disponibilité.',
            'availabilities.*.day_of_week.required' => 'Veuillez indiquer le jour de la semaine.',
            'availabilities.*.day_of_week.integer' => 'Le jour de la semaine doit être un nombre.',
            'availabilities.*.day_of_week.between' => 'Le jour de la semaine doit être entre 0 (dimanche) et 6 (samedi).',
            'availabilities.*.start_time.required' => 'Veuillez indiquer l\'heure de début.',
            'availabilities.*.start_time.date_format' => 'Le format de l\'heure de début est invalide. Utilisez HH:MM (ex: 09:00).',
            'availabilities.*.end_time.required' => 'Veuillez indiquer l\'heure de fin.',
            'availabilities.*.end_time.date_format' => 'Le format de l\'heure de fin est invalide. Utilisez HH:MM (ex: 18:00).',
            'availabilities.*.end_time.after' => 'L\'heure de fin doit être après l\'heure de début.',
        ];
    }
}
