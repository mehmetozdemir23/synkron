<?php

namespace Tests\Feature;

use App\Models\Availability;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Override;
use Tests\TestCase;

class AvailabilityManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_professional_can_view_availabilities(): void
    {
        Availability::factory()->count(5)->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->get('/api/availabilities');

        $response->assertOk();
        $response->assertJsonCount(5, 'availabilities');
    }

    public function test_professional_can_upsert_availabilities(): void
    {
        $response = $this->actingAs($this->user)->post('/api/availabilities', [
            'availabilities' => [
                [
                    'day_of_week' => 1,
                    'start_time' => '09:00',
                    'end_time' => '12:00',
                ],
                [
                    'day_of_week' => 1,
                    'start_time' => '14:00',
                    'end_time' => '18:00',
                ],
                [
                    'day_of_week' => 2,
                    'start_time' => '09:00',
                    'end_time' => '17:00',
                ],
            ],
        ]);

        $response->assertOk();
        $this->assertDatabaseCount('availabilities', 3);
        $this->assertDatabaseHas('availabilities', [
            'user_id' => $this->user->id,
            'day_of_week' => 1,
            'start_time' => '09:00',
        ]);
    }

    public function test_upsert_replaces_existing_availabilities(): void
    {
        Availability::factory()->count(5)->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->post('/api/availabilities', [
            'availabilities' => [
                [
                    'day_of_week' => 1,
                    'start_time' => '10:00',
                    'end_time' => '16:00',
                ],
            ],
        ]);

        $response->assertOk();
        $this->assertDatabaseCount('availabilities', 1);
        $this->assertDatabaseHas('availabilities', [
            'user_id' => $this->user->id,
            'start_time' => '10:00',
        ]);
    }

    public function test_professional_cannot_set_empty_availabilities(): void
    {
        Availability::factory()->count(5)->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->postJson('/api/availabilities', [
            'availabilities' => [],
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('availabilities');
    }
}
