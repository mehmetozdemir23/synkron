<?php

namespace App\Actions;

use App\Models\Service;

class UpdateServiceAction
{
    public function handle(Service $service, array $data): Service
    {
        $service->update($data);

        return $service->fresh();
    }
}
