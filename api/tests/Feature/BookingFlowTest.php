<?php

namespace Tests\Feature;

use App\BookingStatus;
use App\Models\Availability;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Override;
use Tests\TestCase;

class BookingFlowTest extends TestCase
{
    use RefreshDatabase;

    private User $professional;

    private Service $service;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->professional = User::factory()->create([
            'slug' => 'test-professional',
        ]);

        $this->service = Service::factory()->create([
            'user_id' => $this->professional->id,
            'duration_minutes' => 60,
            'is_active' => true,
        ]);

        Availability::factory()->create([
            'user_id' => $this->professional->id,
            'day_of_week' => Carbon::tomorrow()->dayOfWeek,
            'start_time' => '09:00',
            'end_time' => '17:00',
        ]);
    }

    public function test_client_can_view_professional_profile(): void
    {
        $response = $this->get("/api/public/{$this->professional->slug}");

        $response->assertOk();
        $response->assertJsonStructure([
            'professional' => ['firstname', 'lastname', 'slug', 'business_name', 'activity', 'can_accept_bookings'],
            'services',
        ]);
    }

    public function test_client_can_get_available_slots(): void
    {
        $response = $this->get("/api/public/{$this->professional->slug}/services/{$this->service->id}/slots");

        $response->assertOk();
        $response->assertJsonStructure(['slots']);
    }

    public function test_client_can_create_booking(): void
    {
        $startAt = Carbon::tomorrow()->setTime(10, 0);

        $response = $this->post("/api/public/{$this->professional->slug}/services/{$this->service->id}/bookings", [
            'client_name' => 'John Doe',
            'client_email' => 'john@example.com',
            'notes' => 'First consultation',
            'start_at' => $startAt->toIso8601String(),
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('bookings', [
            'client_name' => 'John Doe',
            'client_email' => 'john@example.com',
            'service_id' => $this->service->id,
        ]);
    }

    public function test_professional_can_confirm_booking(): void
    {
        $booking = Booking::factory()->create([
            'user_id' => $this->professional->id,
            'service_id' => $this->service->id,
            'status' => BookingStatus::PENDING->value,
        ]);

        $response = $this->actingAs($this->professional)->post("/api/bookings/{$booking->id}/confirm");

        $response->assertOk();
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => BookingStatus::CONFIRMED->value,
        ]);
    }

    public function test_professional_can_reject_booking(): void
    {
        $booking = Booking::factory()->create([
            'user_id' => $this->professional->id,
            'service_id' => $this->service->id,
            'status' => BookingStatus::PENDING->value,
        ]);

        $response = $this->actingAs($this->professional)->post("/api/bookings/{$booking->id}/reject");

        $response->assertOk();
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => BookingStatus::CANCELLED->value,
        ]);
    }

    public function test_client_can_cancel_booking_with_token(): void
    {
        $booking = Booking::factory()->create([
            'user_id' => $this->professional->id,
            'service_id' => $this->service->id,
            'status' => BookingStatus::CONFIRMED->value,
            'cancellation_token' => 'test-token-123',
        ]);

        $response = $this->post('/api/public/bookings/test-token-123/cancel');

        $response->assertOk();
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => BookingStatus::CANCELLED->value,
        ]);
        $this->assertDatabaseMissing('bookings', [
            'id' => $booking->id,
            'cancelled_at' => null,
        ]);
    }

    public function test_cannot_create_overlapping_bookings(): void
    {
        $startAt = Carbon::tomorrow()->setTime(10, 0);

        Booking::factory()->create([
            'user_id' => $this->professional->id,
            'service_id' => $this->service->id,
            'start_at' => $startAt,
            'end_at' => $startAt->copy()->addHour(),
            'status' => BookingStatus::CONFIRMED->value,
        ]);

        $response = $this->postJson("/api/public/{$this->professional->slug}/services/{$this->service->id}/bookings", [
            'client_name' => 'Jane Doe',
            'client_email' => 'jane@example.com',
            'start_at' => $startAt->toIso8601String(),
        ]);

        $response->assertStatus(422);
    }

    public function test_professional_can_view_their_bookings(): void
    {
        $startOfMonth = Carbon::now()->startOfMonth();

        Booking::factory()->count(3)->create([
            'user_id' => $this->professional->id,
            'service_id' => $this->service->id,
            'start_at' => $startOfMonth->copy()->addDays(5)->setTime(10, 0),
            'end_at' => $startOfMonth->copy()->addDays(5)->setTime(11, 0),
            'status' => BookingStatus::CONFIRMED->value,
        ]);

        $response = $this->actingAs($this->professional)->get('/api/bookings');

        $response->assertOk();
        $response->assertJsonStructure(['bookings']);
        $response->assertJsonCount(3, 'bookings');
    }
}
