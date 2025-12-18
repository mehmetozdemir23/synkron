<?php

namespace App\Actions;

use App\Enums\BookingStatus;
use App\Models\Availability;
use App\Models\Service;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class CalculateAvailableSlotsAction
{
    private const int SLOT_INTERVAL_MINUTES = 15;

    public function handle(Service $service, Carbon $startDate, Carbon $endDate): array
    {
        $timezone = $service->user->timezone;
        $startDate = $startDate->copy()->startOfDay();
        $endDate = $endDate->copy()->endOfDay();

        $availabilities = $service->user->availabilities()
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get()
            ->groupBy('day_of_week');

        $bookings = $this->getBookingsInTimezone($service, $startDate, $endDate, $timezone);

        return $this->generateAllSlots($availabilities, $bookings, $startDate, $endDate, $timezone, $service->duration_minutes);
    }

    private function getBookingsInTimezone(Service $service, Carbon $startDate, Carbon $endDate, string $timezone): Collection
    {
        return $service->user->bookings()
            ->where('status', '!=', BookingStatus::CANCELLED->value)
            ->where('start_at', '<', $endDate)
            ->where('end_at', '>', $startDate)
            ->get()
            ->map(fn ($booking) => (object) [
                'start_at' => $booking->start_at->copy()->setTimezone($timezone),
                'end_at' => $booking->end_at->copy()->setTimezone($timezone),
            ]);
    }

    private function generateAllSlots(Collection $availabilities, Collection $bookings, Carbon $startDate, Carbon $endDate, string $timezone, int $serviceDuration): array
    {
        $slots = [];

        foreach (CarbonPeriod::create($startDate, $endDate) as $date) {
            foreach ($availabilities[$date->dayOfWeek] ?? [] as $availability) {
                array_push($slots, ...$this->generateSlots($date, $timezone, $availability, $serviceDuration, $bookings));
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

        while ($currentSlotStart->copy()->addMinutes($serviceDuration) <= $availabilityEnd) {
            $currentSlotEnd = $currentSlotStart->copy()->addMinutes($serviceDuration);

            if ($this->isSlotAvailable($currentSlotStart, $currentSlotEnd, $bookings)) {
                $slots[] = [
                    'start_at' => $currentSlotStart->copy()->setTimezone('UTC'),
                    'end_at' => $currentSlotEnd->copy()->setTimezone('UTC'),
                ];
            }

            $currentSlotStart->addMinutes(self::SLOT_INTERVAL_MINUTES);
        }

        return $slots;
    }

    private function isSlotAvailable(Carbon $slotStart, Carbon $slotEnd, Collection $bookings): bool
    {
        return $bookings->every(fn ($booking): bool => $slotStart >= $booking->end_at || $slotEnd <= $booking->start_at);
    }
}
