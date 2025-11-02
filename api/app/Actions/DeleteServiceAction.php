<?php

namespace App\Actions;

use App\Models\Service;

class DeleteServiceAction
{
    public function handle(Service $service): bool
    {
        return $service->delete();
    }
}
