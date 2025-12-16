<?php

namespace App\Actions;

use App\BookingStatus;
use App\Models\Availability;
use App\Models\Service;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class CalculateAvailableSlotsAction
{
    public function handle(Service $service, Carbon $startDate, Carbon $endDate): array
    {
        $startDate = $startDate->startOfDay();
        $endDate = $endDate->endOfDay();

        $availabilities = $service->user->availabilities()
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get()
            ->groupBy('day_of_week');

        $bookings = $service->user->bookings()
            ->where('status', '!=', BookingStatus::CANCELLED->value)
            ->where('start_at', '<', $endDate)
            ->where('end_at', '>', $startDate)
            ->get();

        $slots = [];
        foreach (CarbonPeriod::create($startDate, $endDate) as $date) {
            foreach ($availabilities[$date->dayOfWeek] ?? [] as $availability) {
                $slots = [
                    ...$slots,
                    ...$this->generateSlots($date, $service->user->timezone, $availability, $service->duration_minutes, $bookings),
                ];
            }
        }

        return $slots;
    }

    private function generateSlots(Carbon $date, string $timezone, Availability $availability, int $serviceDuration, Collection $bookings): array
    {
        $availabilityStart = Carbon::parse("{$date->format('Y-m-d')} {$availability->start_time}", $timezone);
        $availabilityEnd = Carbon::parse("{$date->format('Y-m-d')} {$availability->end_time}", $timezone);

        $slots = [];
        $currentSlotStart = $availabilityStart->copy();

        $intervalBetweenSlots = 15;

        while ($currentSlotStart->copy()->addMinutes($serviceDuration) <= $availabilityEnd) {
            $currentSlotEnd = $currentSlotStart->copy()->addMinutes($serviceDuration);

            if ($this->isSlotAvailable($currentSlotStart, $currentSlotEnd, $bookings)) {
                $slots[] = [
                    'start_at' => $currentSlotStart->copy(),
                    'end_at' => $currentSlotEnd->copy(),
                ];
            }

            $currentSlotStart->addMinutes($intervalBetweenSlots);
        }

        return $slots;
    }

    private function isSlotAvailable(Carbon $slotStart, Carbon $slotEnd, Collection $bookings): bool
    {
        return $bookings->every(function ($booking) use ($slotStart, $slotEnd): bool {
            $slotStartsAfterBooking = $slotStart >= $booking->end_at;
            $slotEndsBeforeBooking = $slotEnd <= $booking->start_at;

            return $slotStartsAfterBooking || $slotEndsBeforeBooking;
        });
    }
}
