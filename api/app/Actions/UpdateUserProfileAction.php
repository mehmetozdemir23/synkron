<?php

namespace App\Actions;

use App\Models\User;

class UpdateUserProfileAction
{
    public function handle(User $user, array $data): User
    {
        if ((isset($data['firstname']) && $data['firstname'] !== $user->firstname) ||
            (isset($data['lastname']) && $data['lastname'] !== $user->lastname)) {
            $firstname = $data['firstname'] ?? $user->firstname;
            $lastname = $data['lastname'] ?? $user->lastname;
            $fullName = trim($firstname.' '.$lastname);
            $data['slug'] = generate_unique_slug($fullName, $user->id);
        }

        $user->update($data);

        return $user->fresh();
    }
}
