<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Override;
use Tests\TestCase;

class ServiceManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_professional_can_create_service(): void
    {
        $response = $this->actingAs($this->user)->post('/api/services', [
            'name' => 'Consultation',
            'description' => 'Initial consultation',
            'duration_minutes' => 60,
            'price' => 50.00,
            'is_active' => true,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('services', [
            'name' => 'Consultation',
            'user_id' => $this->user->id,
        ]);
    }

    public function test_professional_can_update_service(): void
    {
        $service = Service::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->put("/api/services/{$service->id}", [
            'name' => 'Updated Service',
            'duration_minutes' => 90,
            'price' => 75.00,
            'is_active' => false,
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'name' => 'Updated Service',
        ]);
    }

    public function test_professional_can_delete_service(): void
    {
        $service = Service::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->delete("/api/services/{$service->id}");

        $response->assertOk();
        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }

    public function test_professional_cannot_update_another_users_service(): void
    {
        $otherUser = User::factory()->create();
        $service = Service::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($this->user)->put("/api/services/{$service->id}", [
            'name' => 'Hacked Service',
            'duration_minutes' => 60,
        ]);

        $response->assertForbidden();
    }

    public function test_professional_can_view_their_services(): void
    {
        Service::factory()->count(3)->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->get('/api/services');

        $response->assertOk();
        $response->assertJsonCount(3, 'services');
    }

    public function test_service_price_is_optional(): void
    {
        $response = $this->actingAs($this->user)->post('/api/services', [
            'name' => 'Free Consultation',
            'duration_minutes' => 30,
            'is_active' => true,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('services', [
            'name' => 'Free Consultation',
            'price' => null,
        ]);
    }
}
