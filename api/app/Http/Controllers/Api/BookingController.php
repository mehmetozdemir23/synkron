<?php

namespace App\Http\Controllers\Api;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetBookingsRequest;
use App\Mail\BookingCancelled;
use App\Mail\BookingConfirmation;
use App\Mail\BookingRejected;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function index(GetBookingsRequest $request): JsonResponse
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        $monthStart = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $monthEnd = $monthStart->copy()->endOfMonth();

        $bookings = $request->user()
            ->bookings()
            ->with('service')
            ->whereIn('status', [BookingStatus::PENDING->value, BookingStatus::CONFIRMED->value])
            ->whereBetween('start_at', [$monthStart, $monthEnd])
            ->orderBy('start_at')
            ->get();

        return response()->json(['bookings' => $bookings]);
    }

    public function show(Booking $booking): JsonResponse
    {
        Gate::authorize('view', $booking);

        $booking->load('service');

        return response()->json(['booking' => $booking]);
    }

    public function confirm(Booking $booking): JsonResponse
    {
        Gate::authorize('update', $booking);

        if ($booking->status !== BookingStatus::PENDING->value) {
            return response()->json([
                'message' => 'Seules les réservations en attente peuvent être confirmées.',
            ], 400);
        }

        $booking->update([
            'status' => BookingStatus::CONFIRMED->value,
        ]);

        $booking->load('service', 'professional');

        Mail::to($booking->client_email)->send(new BookingConfirmation($booking));

        return response()->json([
            'message' => 'Réservation confirmée avec succès.',
            'booking' => $booking,
        ]);
    }

    public function reject(Booking $booking): JsonResponse
    {
        Gate::authorize('update', $booking);

        if ($booking->status !== BookingStatus::PENDING->value) {
            return response()->json([
                'message' => 'Seules les réservations en attente peuvent être rejetées.',
            ], 400);
        }

        $booking->update([
            'status' => BookingStatus::CANCELLED->value,
            'cancelled_at' => now(),
        ]);

        $booking->load('service', 'professional');

        Mail::to($booking->client_email)->send(new BookingRejected($booking));

        return response()->json([
            'message' => 'Réservation rejetée avec succès.',
            'booking' => $booking,
        ]);
    }

    public function cancel(Booking $booking): JsonResponse
    {
        Gate::authorize('update', $booking);

        if ($booking->status === BookingStatus::CANCELLED->value) {
            return response()->json([
                'message' => 'Cette réservation est déjà annulée.',
            ], 400);
        }

        $booking->update([
            'status' => BookingStatus::CANCELLED->value,
            'cancelled_at' => now(),
        ]);

        $booking->load('service', 'professional');

        Mail::to($booking->client_email)->send(new BookingCancelled($booking));

        return response()->json([
            'message' => 'Réservation annulée avec succès.',
            'booking' => $booking,
        ]);
    }
}
