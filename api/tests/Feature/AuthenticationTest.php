<?php

namespace Tests\Feature;

use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(): void
    {
        $response = $this->post('/auth/register', [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'firstname' => 'John',
            'lastname' => 'Doe',
        ]);
    }

    public function test_user_can_login(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/auth/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'user' => ['id', 'email', 'firstname', 'lastname'],
        ]);
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/auth/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(422);
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/auth/logout');

        $response->assertOk();
    }

    public function test_authenticated_user_can_get_their_profile(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/api/auth/me');

        $response->assertOk();
        $response->assertJson([
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
            ],
        ]);
    }

    public function test_google_redirect_returns_redirect_response(): void
    {
        $response = $this->get('/auth/google/redirect');

        $response->assertRedirect();
    }

    public function test_new_user_can_authenticate_with_google(): void
    {
        Socialite::fake('google', (new SocialiteUser)->map([
            'id' => 'google-123',
            'email' => 'newuser@gmail.com',
            'name' => 'New User',
        ]));

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'email' => 'newuser@gmail.com',
            'firstname' => 'New',
            'lastname' => 'User',
        ]);

        $user = User::where('email', 'newuser@gmail.com')->first();
        $this->assertNotNull($user);
        $this->assertNotNull($user->slug);
        $this->assertEquals('new-user', $user->slug);
    }

    public function test_existing_user_can_authenticate_with_google(): void
    {
        User::factory()->create([
            'email' => 'existing@gmail.com',
            'firstname' => 'Existing',
            'lastname' => 'User',
        ]);

        Socialite::fake('google', (new SocialiteUser)->map([
            'id' => 'google-456',
            'email' => 'existing@gmail.com',
            'name' => 'Existing User',
        ]));

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect();
        $this->assertEquals(1, User::where('email', 'existing@gmail.com')->count());
    }

    public function test_google_callback_redirects_to_frontend_dashboard_on_success(): void
    {
        Socialite::fake('google', (new SocialiteUser)->map([
            'id' => 'google-789',
            'email' => 'test@gmail.com',
            'name' => 'Test User',
        ]));

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect();
        $this->assertTrue(str_contains((string) $response->headers->get('Location'), '/dashboard'));
    }

    public function test_google_callback_redirects_to_login_with_error_on_exception(): void
    {
        Socialite::fake('google', function (): void {
            throw new Exception('OAuth error');
        });

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect();
        $this->assertTrue(str_contains((string) $response->headers->get('Location'), '/login?error='));
    }
}
