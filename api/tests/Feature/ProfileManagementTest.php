<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_profile(): void
    {
        $user = User::factory()->create([
            'firstname' => 'John',
            'lastname' => 'Doe',
        ]);

        $response = $this->actingAs($user)->put('/api/profile', [
            'firstname' => 'Jane',
            'lastname' => 'Smith',
            'business_name' => 'Jane Smith Consulting',
            'activity' => 'Consultant',
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'firstname' => 'Jane',
            'lastname' => 'Smith',
            'business_name' => 'Jane Smith Consulting',
        ]);
    }

    public function test_slug_updates_when_name_changes(): void
    {
        $user = User::factory()->create([
            'firstname' => 'John',
            'lastname' => 'Doe',
            'slug' => 'john-doe',
        ]);

        $response = $this->actingAs($user)->put('/api/profile', [
            'firstname' => 'Jane',
            'lastname' => 'Smith',
        ]);

        $response->assertOk();
        $user->refresh();
        $this->assertEquals('jane-smith', $user->slug);
    }

    public function test_user_can_change_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword'),
        ]);

        $response = $this->actingAs($user)->put('/api/profile/password', [
            'current_password' => 'oldpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertOk();
        $user->refresh();
        $this->assertTrue(Hash::check('newpassword123', $user->password));
    }

    public function test_user_cannot_change_password_with_wrong_current_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword'),
        ]);

        $response = $this->actingAs($user)->put('/api/profile/password', [
            'current_password' => 'wrongpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertStatus(422);
    }
}
