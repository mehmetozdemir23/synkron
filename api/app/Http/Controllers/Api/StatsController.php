<?php

namespace App\Http\Controllers\Api;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $now = now();
        $monthStart = $now->copy()->startOfMonth();
        $monthEnd = $now->copy()->endOfMonth();
        $confirmed = BookingStatus::CONFIRMED->value;
        $pending = BookingStatus::PENDING->value;

        $bookingStats = $user->bookings()
            ->selectRaw('COUNT(bookings.id) as total_count')
            ->selectRaw('SUM(CASE WHEN bookings.status = ? AND bookings.start_at BETWEEN ? AND ? THEN 1 ELSE 0 END) as upcoming_confirmed', [$confirmed, $monthStart, $monthEnd])
            ->selectRaw('SUM(CASE WHEN bookings.status = ? AND bookings.start_at BETWEEN ? AND ? THEN 1 ELSE 0 END) as upcoming_pending', [$pending, $monthStart, $monthEnd])
            ->selectRaw('SUM(CASE WHEN bookings.status = ? AND bookings.start_at BETWEEN ? AND ? THEN 1 ELSE 0 END) as monthly_confirmed_count', [$confirmed, $monthStart, $monthEnd])
            ->selectRaw('COALESCE(SUM(CASE WHEN bookings.status = ? AND bookings.start_at BETWEEN ? AND ? THEN services.price ELSE 0 END), 0) as monthly_revenue', [$confirmed, $monthStart, $monthEnd])
            ->join('services', 'bookings.service_id', 'services.id')
            ->first();

        $stats = [
            'availabilities' => $user->availabilities()->count(),
            'bookings' => (int) ($bookingStats->total_count ?? 0),
            'upcoming_confirmed_bookings' => (int) ($bookingStats->upcoming_confirmed ?? 0),
            'upcoming_pending_bookings' => (int) ($bookingStats->upcoming_pending ?? 0),
            'confirmed_this_month' => (int) ($bookingStats->monthly_confirmed_count ?? 0),
            'revenue_this_month' => number_format((float) ($bookingStats->monthly_revenue ?? 0), 2, '.', ''),
        ];

        return response()->json(['stats' => $stats]);
    }
}
