<?php

namespace Tests\Feature;

use App\Models\AnonymousUser;
use App\Models\Card;
use App\Models\User;
use App\Models\Prime;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;


class ApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;



    public function test_register_creates_new_user_and_token(): void
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ];

        $response = $this->postJson('/api/register', $userData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com'
        ]);
        $response->assertJsonStructure(['token']);
    }

    public function test_login_with_valid_credentials_and_create_token()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => ('password123')
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'token_name' => 'Test User',
            'password' => 'password123'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
        return $response;
    }

    public function test_login_with_invalid_credentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertStatus(401);
    }

    public function test_logout_authenticated_user()
    {
        $user = User::factory(1)->create()->first();
        Sanctum::actingAs($user);

        $response = $this->post('/api/logout', [], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);

        $response->assertStatus(200);
    }

    public function test_logout_unauthenticated_user()
    {
        $response = $this->post('/api/logout', [], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);

        $response->assertStatus(401);
    }

    public function test_get_authenticated_user()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $response = $this->get('/api/user', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);
        /*     $response->assertJson([
            'id' => $this->user->id,
            'email' => $this->user->email
        ]);*/
    }

    public function test_get_user_without_authentication()
    {
        $response = $this->get('/api/user', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401);
    }




    // Tests for ApiController (protected routes)
    public function test_get_ages_authenticated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->get('/api/age', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);
    }

    public function test_get_ages_unauthenticated()
    {
        $response = $this->get('/api/age', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401);
    }

    public function test_get_tarif_type_authenticated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->get('/api/tarif_type', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);
    }

    public function test_get_tarif_type_unauthenticated()
    {
        $response = $this->get('/api/tarif_type', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401);
    }

    public function test_get_franchises_authenticated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->get('/api/franchises', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);
    }

    public function test_get_franchises_with_age_id_authenticated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->get('/api/franchises/1', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);
    }

    public function test_get_franchises_unauthenticated()
    {
        $response = $this->get('/api/franchises', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401);
    }

    public function test_get_primes_authenticated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->get('/api/primes/1', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);
    }

    public function test_post_primes_authenticated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->post('/api/primes', [
            'profile_id' => 1,
            'data' => 'test'
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);

        $response->assertStatus(200);
    }

    public function test_get_primes_unauthenticated()
    {
        $response = $this->get('/api/primes/1', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401);
    }

    public function test_get_selection_authenticated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->get('/api/selection', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);
    }

    public function test_post_selection_authenticated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->post('/api/selection/1/1', [], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);

        $response->assertStatus(201);
    }

    public function test_delete_selection_authenticated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $anonymousUser = AnonymousUser::factory()->create();
        $profile = Profile::factory()->create([
            'anonymous_user_id' => $anonymousUser->id,
        ]);
        $prime = Prime::factory()->create();

        $card = Card::factory()->create([
            'profile_id' => $profile->id,
            'prime_id' => $prime->id,
        ]);

        $response = $this->delete("/api/selection/{$profile->id}/{$prime->id}", [], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);
    }

    public function test_get_selection_unauthenticated()
    {
        $response = $this->get('/api/selection', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401);
    }

    public function test_post_regions_authenticated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->post('/api/regions', [
            'region_data' => 'test'
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);

        $response->assertStatus(200);
    }

    public function test_post_regions_unauthenticated()
    {
        $response = $this->post('/api/regions', [
            'region_data' => 'test'
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);

        $response->assertStatus(401);
    }


    // Validation tests
    public function test_register_validation_errors()
    {
        $response = $this->post('/api/register', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => '123'
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    public function test_login_validation_errors()
    {
        $response = $this->post('/api/login', [
            'email' => '',
            'password' => ''
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email', 'password']);
    }
}
