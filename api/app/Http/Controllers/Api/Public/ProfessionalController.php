<?php

namespace App\Http\Controllers\Api\Public;

use App\Actions\CalculateAvailableSlotsAction;
use App\Actions\CreateBookingAction;
use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBookingRequest;
use App\Http\Requests\GetAvailableSlotsRequest;
use App\Mail\BookingCancelledByClient;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class ProfessionalController extends Controller
{
    public function show(string $slug): JsonResponse
    {
        $professional = User::where('slug', $slug)
            ->with([
                'services' => function ($query): void {
                    $query->where('is_active', true);
                },
            ])
            ->firstOrFail();

        $canAcceptBookings = $professional->canCreateBooking();

        return response()->json([
            'professional' => [
                'firstname' => $professional->firstname,
                'lastname' => $professional->lastname,
                'business_name' => $professional->business_name,
                'activity' => $professional->activity,
                'slug' => $professional->slug,
                'timezone' => $professional->timezone,
                'can_accept_bookings' => $canAcceptBookings,
            ],
            'services' => $professional->services,
        ]);
    }

    public function availableSlots(
        string $slug,
        int $serviceId,
        GetAvailableSlotsRequest $request,
        CalculateAvailableSlotsAction $action
    ): JsonResponse {
        $professional = User::where('slug', $slug)->firstOrFail();
        $service = Service::where('id', $serviceId)
            ->where('user_id', $professional->id)
            ->where('is_active', true)
            ->firstOrFail();
        $timezone = $professional->timezone;

        $startDate = $request->input('start_date')
            ? Carbon::parse($request->input('start_date'), $timezone)
            : Carbon::now($timezone);

        $endDate = $request->input('end_date')
            ? Carbon::parse($request->input('end_date'), $timezone)
            : Carbon::now($timezone)->addDays(30);

        $slots = $action->handle($service, $startDate, $endDate);

        return response()->json(['slots' => $slots]);
    }

    public function createBooking(
        string $slug,
        int $serviceId,
        CreateBookingRequest $request,
        CreateBookingAction $action
    ): JsonResponse {
        $professional = User::where('slug', $slug)->firstOrFail();
        $service = Service::where('id', $serviceId)
            ->where('user_id', $professional->id)
            ->where('is_active', true)
            ->firstOrFail();

        $validated = $request->validated();
        $validated['start_at'] = Carbon::parse($validated['start_at'])->setTimezone('UTC')->toIso8601String();

        $booking = $action->handle($service, $validated);

        return response()->json([
            'message' => 'Réservation effectuée avec succès !',
            'booking' => $booking,
        ], 201);
    }

    public function getBooking(int $id): JsonResponse
    {
        $booking = Booking::with('service', 'professional')->findOrFail($id);

        return response()->json([
            'booking' => [
                'id' => $booking->id,
                'client_name' => $booking->client_name,
                'client_email' => $booking->client_email,
                'notes' => $booking->notes,
                'start_at' => $booking->start_at,
                'end_at' => $booking->end_at,
                'service' => [
                    'id' => $booking->service->id,
                    'name' => $booking->service->name,
                ],
                'professional' => [
                    'id' => $booking->professional->id,
                    'name' => $booking->professional->name,
                    'slug' => $booking->professional->slug,
                ],
            ],
        ]);
    }

    public function cancelBooking(string $token): JsonResponse
    {
        $booking = Booking::where('cancellation_token', $token)->firstOrFail();

        if ($booking->status === BookingStatus::CANCELLED->value) {
            return response()->json([
                'message' => 'Cette réservation est déjà annulée.',
            ], 400);
        }

        if ($booking->start_at->isPast()) {
            return response()->json([
                'message' => 'Impossible d\'annuler une réservation passée.',
            ], 400);
        }

        $booking->update([
            'status' => BookingStatus::CANCELLED->value,
            'cancelled_at' => now(),
        ]);

        $booking->load('service', 'professional');

        Mail::to($booking->professional->email)->send(new BookingCancelledByClient($booking));

        return response()->json([
            'message' => 'Réservation annulée avec succès.',
            'booking' => $booking,
        ]);
    }
}
