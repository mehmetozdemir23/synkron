<?php

namespace App\Http\Controllers\Api;

use App\Actions\CreateServiceAction;
use App\Actions\DeleteServiceAction;
use App\Actions\UpdateServiceAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ServiceController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $services = $request->user()->services;

        return response()->json(['services' => $services]);
    }

    public function store(CreateServiceRequest $request, CreateServiceAction $action): JsonResponse
    {
        $service = $action->handle($request->user(), $request->validated());

        return response()->json(['service' => $service], 201);
    }

    public function show(Service $service): JsonResponse
    {
        Gate::authorize('view', $service);

        return response()->json(['service' => $service]);
    }

    public function update(UpdateServiceRequest $request, Service $service, UpdateServiceAction $action): JsonResponse
    {

        $service = $action->handle($service, $request->validated());

        return response()->json(['service' => $service]);
    }

    public function destroy(Service $service, DeleteServiceAction $action): JsonResponse
    {
        Gate::authorize('delete', $service);

        $action->handle($service);

        return response()->json(['message' => 'Service supprimé avec succès.']);
    }
}
