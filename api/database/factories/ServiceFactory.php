<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->randomElement([
                'Consultation',
                'Séance de coaching',
                'Massage thérapeutique',
                'Cours particulier',
                'Consultation nutritionniste',
                'Séance de psychothérapie',
            ]),
            'duration_minutes' => fake()->randomElement([30, 45, 60, 90, 120]),
            'price' => fake()->randomFloat(2, 30, 150),
            'is_active' => true,
        ];
    }

    /**
     * Service inactif
     */
    public function inactive(): static
    {
        return $this->state(fn () => [
            'is_active' => false,
        ]);
    }

    /**
     * Service gratuit
     */
    public function free(): static
    {
        return $this->state(fn () => [
            'price' => null,
        ]);
    }
}
