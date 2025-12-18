<?php

namespace Database\Factories;

use App\Enums\BookingStatus;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    public function definition(): array
    {
        $startAt = fake()->dateTimeBetween('+1 day', '+30 days');
        $durationMinutes = fake()->randomElement([30, 45, 60, 90, 120]);
        $service = Service::factory()->create();

        return [
            'user_id' => $service->user_id,
            'service_id' => $service->id,
            'client_name' => fake()->name(),
            'client_email' => fake()->safeEmail(),
            'start_at' => $startAt,
            'end_at' => (clone $startAt)->modify("+{$durationMinutes} minutes"),
            'status' => fake()->randomElement([
                BookingStatus::PENDING->value,
                BookingStatus::CONFIRMED->value,
                BookingStatus::CANCELLED->value,
            ]),
            'cancellation_token' => fake()->sha256(),
        ];
    }

    public function confirmed(): static
    {
        return $this->state(fn () => [
            'status' => BookingStatus::CONFIRMED->value,
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn () => [
            'status' => BookingStatus::CANCELLED->value,
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn () => [
            'status' => BookingStatus::PENDING->value,
        ]);
    }
}
