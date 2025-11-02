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
                    ...$this->generateSlots($date, $availability, $service->duration_minutes, $bookings),
                ];
            }
        }

        return $slots;
    }

    private function generateSlots(Carbon $date, Availability $availability, int $duration, Collection $bookings): array
    {
        $start = Carbon::parse("{$date->format('Y-m-d')} {$availability->start_time}");
        $end = Carbon::parse("{$date->format('Y-m-d')} {$availability->end_time}");
        $slots = [];

        while ($start->copy()->addMinutes($duration) <= $end) {
            $slotEnd = $start->copy()->addMinutes($duration);

            if ($this->isAvailable($start, $slotEnd, $bookings)) {
                $slots[] = [
                    'start_at' => $start->toIso8601String(),
                    'end_at' => $slotEnd->toIso8601String(),
                ];
            }

            $start->addMinutes($duration);
        }

        return $slots;
    }

    private function isAvailable(Carbon $slotStart, Carbon $slotEnd, Collection $bookings): bool
    {
        return $bookings->every(
            fn ($booking): bool => $slotStart >= $booking->end_at || $slotEnd <= $booking->start_at
        );
    }
}
