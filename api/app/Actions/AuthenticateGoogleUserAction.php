<?php

namespace App\Actions;

use App\Models\User;
use App\Notifications\ProfessionalWelcome;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthenticateGoogleUserAction
{
    public function handle(array $googleData): User
    {
        $user = User::where('email', $googleData['email'])->first();

        if ($user) {
            return $user;
        }

        $nameParts = explode(' ', (string) $googleData['name'], 2);
        $firstname = $nameParts[0] ?? '';
        $lastname = $nameParts[1] ?? '';

        $slug = generate_unique_slug($googleData['name']);

        $user = User::create([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $googleData['email'],
            'password' => Hash::make(Str::random(32)),
            'slug' => $slug,
            'business_name' => $googleData['name'] ?? null,
            'timezone' => 'Europe/Paris',
        ]);

        $user->notify(new ProfessionalWelcome(
            name: $googleData['name'],
            businessName: $user->business_name ?? $googleData['name']
        ));

        return $user;
    }
}
