<?php

namespace App\Http\Controllers\Api;

use App\Actions\UpsertAvailabilitiesAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpsertAvailabilitiesRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $availabilities = $request->user()
            ->availabilities()
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        return response()->json(['availabilities' => $availabilities]);
    }

    public function upsert(UpsertAvailabilitiesRequest $request, UpsertAvailabilitiesAction $action): JsonResponse
    {
        $action->handle($request->user(), $request->validated()['availabilities']);

        $availabilities = $request->user()
            ->availabilities()
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        return response()->json([
            'message' => 'Disponibilités mises à jour avec succès.',
            'availabilities' => $availabilities,
        ]);
    }
}
