<?php

namespace App\Actions;

use App\Models\User;
use App\Notifications\ProfessionalWelcome;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction
{
    public function handle(array $data): User
    {
        $fullName = trim($data['firstname'].' '.$data['lastname']);
        $slug = User::generateSlug($fullName);

        $user = User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'slug' => $slug,
            'business_name' => $data['business_name'] ?? null,
            'activity' => $data['activity'] ?? null,
        ]);

        $user->notify(new ProfessionalWelcome(
            name: $fullName,
            businessName: $user->business_name ?? $fullName
        ));

        return $user;
    }
}
