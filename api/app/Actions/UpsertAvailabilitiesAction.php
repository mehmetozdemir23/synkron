<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UpsertAvailabilitiesAction
{
    public function handle(User $user, array $availabilities): void
    {
        DB::transaction(function () use ($user, $availabilities): void {

            $user->availabilities()->delete();

            foreach ($availabilities as $availability) {
                $user->availabilities()->create([
                    'day_of_week' => $availability['day_of_week'],
                    'start_time' => $availability['start_time'],
                    'end_time' => $availability['end_time'],
                ]);
            }
        });
    }
}
