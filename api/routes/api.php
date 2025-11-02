<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AvailabilityController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\Public\ProfessionalController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\StatsController;
use App\Http\Controllers\Api\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::prefix('public')->middleware('throttle:60,1')->group(function (): void {
    Route::get('/{slug}', [ProfessionalController::class, 'show']);
    Route::get('/{slug}/services/{serviceId}/slots', [ProfessionalController::class, 'availableSlots']);
    Route::post('/{slug}/services/{serviceId}/bookings', [ProfessionalController::class, 'createBooking'])
        ->middleware('throttle:30,1');
    Route::get('/bookings/{id}', [ProfessionalController::class, 'getBooking']);
    Route::post('/bookings/{token}/cancel', [ProfessionalController::class, 'cancelBooking'])
        ->middleware('throttle:10,1');
});

Route::post(
    'stripe/webhook',
    '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook'
);

Route::middleware(['auth:sanctum'])->group(function (): void {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    Route::put('/profile', [ProfileController::class, 'update']);
    Route::put('/profile/password', [ProfileController::class, 'updatePassword']);

    Route::get('/stats', [StatsController::class, 'index']);

    Route::apiResource('services', ServiceController::class);

    Route::get('/availabilities', [AvailabilityController::class, 'index']);
    Route::post('/availabilities', [AvailabilityController::class, 'upsert']);

    Route::get('/bookings', [BookingController::class, 'index']);
    Route::get('/bookings/{booking}', [BookingController::class, 'show']);
    Route::post('/bookings/{booking}/confirm', [BookingController::class, 'confirm']);
    Route::post('/bookings/{booking}/reject', [BookingController::class, 'reject']);
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel']);

    Route::prefix('subscription')->group(function (): void {
        Route::get('/status', [SubscriptionController::class, 'status']);
        Route::post('/checkout', [SubscriptionController::class, 'createCheckoutSession']);
        Route::post('/portal', [SubscriptionController::class, 'billingPortal']);
        Route::post('/cancel', [SubscriptionController::class, 'cancel']);
        Route::post('/resume', [SubscriptionController::class, 'resume']);
    });
});
