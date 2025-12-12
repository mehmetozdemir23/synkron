<?php

namespace App\Actions;

use App\BookingStatus;
use App\Models\Booking;
use App\Models\Service;
use App\Notifications\NewBookingNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CreateBookingAction
{
    public function handle(Service $service, array $data): Booking
    {
        return DB::transaction(function () use ($service, $data) {
            $user = $service->user;

            $startAt = Carbon::parse($data['start_at']);
            $endAt = $startAt->copy()->addMinutes($service->duration_minutes);

            if ($startAt->isPast()) {
                throw ValidationException::withMessages([
                    'start_at' => ['Le créneau sélectionné est dans le passé.'],
                ]);
            }

            $conflict = Booking::where('user_id', $user->id)
                ->where('status', '!=', BookingStatus::CANCELLED->value)
                ->where('start_at', '<', $endAt)
                ->where('end_at', '>', $startAt)
                ->lockForUpdate()
                ->exists();

            if ($conflict) {
                throw ValidationException::withMessages([
                    'start_at' => ['Ce créneau n\'est plus disponible.'],
                ]);
            }

            if (! $user->canCreateBooking()) {
                throw ValidationException::withMessages([
                    'limit' => ['Ce professionnel ne peut plus accepter de réservations pour ce mois. Veuillez réessayer le mois prochain.'],
                ]);
            }

            $booking = Booking::create([
                'user_id' => $user->id,
                'service_id' => $service->id,
                'client_name' => $data['client_name'],
                'client_email' => $data['client_email'],
                'notes' => $data['notes'] ?? null,
                'start_at' => $startAt,
                'end_at' => $endAt,
                'status' => BookingStatus::PENDING->value,
                'cancellation_token' => Str::random(64),
            ]);

            $booking->load('service', 'professional');

            $user->notify(new NewBookingNotification($booking));

            return $booking;
        });
    }
}
