<?php

namespace App\Actions;

use App\Models\Service;
use App\Models\User;

class CreateServiceAction
{
    public function handle(User $user, array $data): Service
    {
        return $user->services()->create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'duration_minutes' => $data['duration_minutes'],
            'price' => $data['price'] ?? null,
            'is_active' => $data['is_active'] ?? true,
        ]);
    }
}
