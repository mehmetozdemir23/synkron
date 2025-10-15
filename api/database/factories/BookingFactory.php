<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
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
            'status' => fake()->randomElement(['pending', 'confirmed', 'cancelled']),
            'cancellation_token' => fake()->sha256(),
        ];
    }

    /**
     * Indicate that the booking is confirmed.
     */
    public function confirmed(): static
    {
        return $this->state(fn () => [
            'status' => 'confirmed',
        ]);
    }

    /**
     * Indicate that the booking is cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn () => [
            'status' => 'cancelled',
        ]);
    }

    /**
     * Indicate that the booking is pending.
     */
    public function pending(): static
    {
        return $this->state(fn () => [
            'status' => 'pending',
        ]);
    }
}
