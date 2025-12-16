<?php

namespace Tests\Feature;

use App\BookingStatus;
use App\Models\Availability;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_can_view_professional_profile(): void
    {
        $professional = User::factory()->create();

        $response = $this->get("/api/public/{$professional->slug}");

        $response->assertOk();
        $response->assertJsonStructure([
            'professional' => ['firstname', 'lastname', 'slug', 'business_name', 'activity', 'can_accept_bookings'],
            'services',
        ]);
    }

    public function test_client_can_get_available_slots(): void
    {
        $professional = User::factory()->create();
        $service = Service::factory()->create(['user_id' => $professional->id, 'is_active' => true]);

        $response = $this->get("/api/public/{$professional->slug}/services/{$service->id}/slots");

        $response->assertOk();
        $response->assertJsonStructure(['slots']);
    }

    public function test_slots_are_within_availability_hours(): void
    {
        $professional = User::factory()->create();
        $service = Service::factory()->create(['user_id' => $professional->id, 'duration_minutes' => 60, 'is_active' => true]);

        Availability::factory()->create([
            'user_id' => $professional->id,
            'day_of_week' => Carbon::tomorrow($professional->timezone)->dayOfWeek,
            'start_time' => '09:00',
            'end_time' => '17:00',
        ]);

        $response = $this->get("/api/public/{$professional->slug}/services/{$service->id}/slots");
        $slots = $response->json('slots');

        $this->assertNotEmpty($slots);

        foreach ($slots as $slot) {
            $start = Carbon::parse($slot['start_at'])->setTimezone($professional->timezone);
            $end = Carbon::parse($slot['end_at'])->setTimezone($professional->timezone);

            $this->assertGreaterThanOrEqual(9, $start->hour);
            $this->assertLessThanOrEqual(17, $end->hour);
            $this->assertEquals(60, $start->diffInMinutes($end));
        }
    }

    public function test_slots_do_not_include_booked_times(): void
    {
        $professional = User::factory()->create();
        $service = Service::factory()->create(['user_id' => $professional->id, 'duration_minutes' => 60, 'is_active' => true]);
        $testDate = Carbon::now($professional->timezone)->addDays(5)->startOfDay();

        Availability::factory()->create([
            'user_id' => $professional->id,
            'day_of_week' => $testDate->dayOfWeek,
            'start_time' => '09:00',
            'end_time' => '17:00',
        ]);

        Booking::factory()->create([
            'user_id' => $professional->id,
            'service_id' => $service->id,
            'start_at' => $testDate->copy()->setTime(10, 0)->setTimezone('UTC'),
            'end_at' => $testDate->copy()->setTime(11, 0)->setTimezone('UTC'),
            'status' => BookingStatus::CONFIRMED->value,
        ]);

        $response = $this->get("/api/public/{$professional->slug}/services/{$service->id}/slots?start_date={$testDate->format('Y-m-d')}&end_date={$testDate->format('Y-m-d')}");
        $slots = $response->json('slots');

        $this->assertGreaterThan(20, count($slots));

        $slotStarts = array_map(
            fn (array $slot): string => Carbon::parse($slot['start_at'])->setTimezone($professional->timezone)->format('H:i'),
            $slots
        );

        $this->assertNotContains('10:00', $slotStarts);
    }

    public function test_slots_count_matches_expected_for_service_duration(): void
    {
        $professional = User::factory()->create();
        $service = Service::factory()->create(['user_id' => $professional->id, 'duration_minutes' => 60, 'is_active' => true]);
        $testDate = Carbon::now($professional->timezone)->addDays(5)->startOfDay();

        Availability::factory()->create([
            'user_id' => $professional->id,
            'day_of_week' => $testDate->dayOfWeek,
            'start_time' => '09:00',
            'end_time' => '17:00',
        ]);

        $response = $this->get("/api/public/{$professional->slug}/services/{$service->id}/slots?start_date={$testDate->format('Y-m-d')}&end_date={$testDate->format('Y-m-d')}");
        $slots = $response->json('slots');

        $this->assertCount(29, $slots);
    }

    public function test_slots_with_30min_service_duration(): void
    {
        $professional = User::factory()->create();
        $service = Service::factory()->create(['user_id' => $professional->id, 'duration_minutes' => 30, 'is_active' => true]);
        $testDate = Carbon::now($professional->timezone)->addDays(5)->startOfDay();

        Availability::factory()->create([
            'user_id' => $professional->id,
            'day_of_week' => $testDate->dayOfWeek,
            'start_time' => '09:00',
            'end_time' => '17:00',
        ]);

        $response = $this->get("/api/public/{$professional->slug}/services/{$service->id}/slots?start_date={$testDate->format('Y-m-d')}&end_date={$testDate->format('Y-m-d')}");
        $slots = $response->json('slots');

        $this->assertCount(31, $slots);

        for ($i = 0; $i < count($slots) - 1; $i++) {
            $this->assertEquals(
                15,
                Carbon::parse($slots[$i]['start_at'])->diffInMinutes(Carbon::parse($slots[$i + 1]['start_at']))
            );
        }
    }

    public function test_slots_exclude_cancelled_bookings(): void
    {
        $professional = User::factory()->create();
        $service = Service::factory()->create(['user_id' => $professional->id, 'duration_minutes' => 60, 'is_active' => true]);
        $testDate = Carbon::now($professional->timezone)->addDays(5)->startOfDay();

        Availability::factory()->create([
            'user_id' => $professional->id,
            'day_of_week' => $testDate->dayOfWeek,
            'start_time' => '09:00',
            'end_time' => '17:00',
        ]);

        Booking::factory()->create([
            'user_id' => $professional->id,
            'service_id' => $service->id,
            'start_at' => $testDate->copy()->setTime(10, 0)->setTimezone('UTC'),
            'end_at' => $testDate->copy()->setTime(11, 0)->setTimezone('UTC'),
            'status' => BookingStatus::CANCELLED->value,
        ]);

        $response = $this->get("/api/public/{$professional->slug}/services/{$service->id}/slots?start_date={$testDate->format('Y-m-d')}&end_date={$testDate->format('Y-m-d')}");
        $slots = $response->json('slots');

        $slotHours = array_map(
            fn (array $slot) => Carbon::parse($slot['start_at'])->setTimezone($professional->timezone)->hour,
            $slots
        );

        $this->assertContains(10, $slotHours);
    }

    public function test_slots_across_multiple_availability_windows(): void
    {
        $professional = User::factory()->create();
        $service = Service::factory()->create(['user_id' => $professional->id, 'duration_minutes' => 60, 'is_active' => true]);
        $testDate = Carbon::now($professional->timezone)->addDays(5)->startOfDay();

        Availability::factory()->create([
            'user_id' => $professional->id,
            'day_of_week' => $testDate->dayOfWeek,
            'start_time' => '09:00',
            'end_time' => '12:00',
        ]);

        Availability::factory()->create([
            'user_id' => $professional->id,
            'day_of_week' => $testDate->dayOfWeek,
            'start_time' => '14:00',
            'end_time' => '17:00',
        ]);

        $response = $this->get("/api/public/{$professional->slug}/services/{$service->id}/slots?start_date={$testDate->format('Y-m-d')}&end_date={$testDate->format('Y-m-d')}");
        $slots = $response->json('slots');

        $this->assertCount(18, $slots);

        $slotHours = array_map(
            fn (array $slot) => Carbon::parse($slot['start_at'])->setTimezone($professional->timezone)->hour,
            $slots
        );

        $this->assertNotContains(12, $slotHours);
        $this->assertNotContains(13, $slotHours);
    }

    public function test_client_can_create_booking(): void
    {
        $professional = User::factory()->create();
        $service = Service::factory()->create(['user_id' => $professional->id, 'is_active' => true]);
        $startAt = Carbon::now($professional->timezone)->addDays(5)->setTime(10, 0);

        Availability::factory()->create([
            'user_id' => $professional->id,
            'day_of_week' => $startAt->dayOfWeek,
            'start_time' => '09:00',
            'end_time' => '17:00',
        ]);

        $response = $this->post("/api/public/{$professional->slug}/services/{$service->id}/bookings", [
            'client_name' => 'John Doe',
            'client_email' => 'john@test.com',
            'notes' => 'Test booking',
            'start_at' => $startAt->toIso8601String(),
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('bookings', [
            'client_name' => 'John Doe',
            'client_email' => 'john@test.com',
            'service_id' => $service->id,
        ]);
    }

    public function test_professional_can_confirm_booking(): void
    {
        $professional = User::factory()->create();
        $service = Service::factory()->create(['user_id' => $professional->id]);
        $booking = Booking::factory()->create([
            'user_id' => $professional->id,
            'service_id' => $service->id,
            'status' => BookingStatus::PENDING->value,
        ]);

        $response = $this->actingAs($professional)->post("/api/bookings/{$booking->id}/confirm");

        $response->assertOk();
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => BookingStatus::CONFIRMED->value,
        ]);
    }

    public function test_professional_can_reject_booking(): void
    {
        $professional = User::factory()->create();
        $service = Service::factory()->create(['user_id' => $professional->id]);
        $booking = Booking::factory()->create([
            'user_id' => $professional->id,
            'service_id' => $service->id,
            'status' => BookingStatus::PENDING->value,
        ]);

        $response = $this->actingAs($professional)->post("/api/bookings/{$booking->id}/reject");

        $response->assertOk();
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => BookingStatus::CANCELLED->value,
        ]);
    }

    public function test_client_can_cancel_booking_with_token(): void
    {
        $professional = User::factory()->create();
        $service = Service::factory()->create(['user_id' => $professional->id]);
        $booking = Booking::factory()->create([
            'user_id' => $professional->id,
            'service_id' => $service->id,
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
        $professional = User::factory()->create();
        $service = Service::factory()->create(['user_id' => $professional->id, 'is_active' => true]);
        $startAt = Carbon::tomorrow()->setTime(10, 0);

        Booking::factory()->create([
            'user_id' => $professional->id,
            'service_id' => $service->id,
            'start_at' => $startAt,
            'end_at' => $startAt->copy()->addHour(),
            'status' => BookingStatus::CONFIRMED->value,
        ]);

        $response = $this->postJson("/api/public/{$professional->slug}/services/{$service->id}/bookings", [
            'client_name' => 'Jane Doe',
            'client_email' => 'jane@example.com',
            'start_at' => $startAt->toIso8601String(),
        ]);

        $response->assertStatus(422);
    }

    public function test_professional_can_view_their_bookings(): void
    {
        $professional = User::factory()->create();
        $service = Service::factory()->create(['user_id' => $professional->id]);
        $startOfMonth = Carbon::now()->startOfMonth();

        Booking::factory()->count(3)->create([
            'user_id' => $professional->id,
            'service_id' => $service->id,
            'start_at' => $startOfMonth->copy()->addDays(5)->setTime(10, 0),
            'end_at' => $startOfMonth->copy()->addDays(5)->setTime(11, 0),
            'status' => BookingStatus::CONFIRMED->value,
        ]);

        $response = $this->actingAs($professional)->get('/api/bookings');

        $response->assertOk();
        $response->assertJsonStructure(['bookings']);
        $response->assertJsonCount(3, 'bookings');
    }
}
