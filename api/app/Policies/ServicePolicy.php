<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;

class ServicePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Only the owner can view their service.
     */
    public function view(User $user, Service $service): bool
    {
        return $service->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Only the owner can update their service.
     */
    public function update(User $user, Service $service): bool
    {
        return $service->user_id === $user->id;
    }

    /**
     * Only the owner can delete their service.
     */
    public function delete(User $user, Service $service): bool
    {
        return $service->user_id === $user->id;
    }
}
