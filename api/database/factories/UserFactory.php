<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        $firstname = fake()->firstName();
        $lastname = fake()->lastName();
        $fullName = $firstname.' '.$lastname;

        return [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'slug' => User::generateSlug($fullName),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'business_name' => fake()->company(),
            'activity' => fake()->jobTitle(),
            'timezone' => fake()->timezone(),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
