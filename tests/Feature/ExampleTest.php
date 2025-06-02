<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;


class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create Laravel's application for tests
        $this->createApplication();

        $this->user = User::factory()->create();
    }

    public function test_register_creates_new_user(): void
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $userData);
        $response->assertStatus(201)
            ->assertDatabaseHas('users', [
                'email' => 'test@example.com'
            ]);
    }

    public function test_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
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
        Sanctum::actingAs($this->user);

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
        Sanctum::actingAs($this->user);

        $response = $this->get('/api/user', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $this->user->id,
            'email' => $this->user->email
        ]);
    }

    public function test_get_user_without_authentication()
    {
        $response = $this->get('/api/user', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(401);
    }

    // Tests for token creation
    public function test_create_token_authenticated()
    {
        Sanctum::actingAs($this->user);

        $response = $this->post('/api/tokens/create', [
            'token_name' => 'test-token'
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
    }

    public function test_create_token_unauthenticated()
    {
        $response = $this->post('/api/tokens/create', [
            'token_name' => 'test-token'
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);

        $response->assertStatus(401);
    }

    // Tests for Posts (apiResource)
    public function test_get_all_posts()
    {
        Post::factory()->count(3)->create();

        $response = $this->get('/api/posts', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_create_post()
    {
        $postData = [
            'title' => 'Test Post',
            'content' => 'This is a test post content',
            'user_id' => $this->user->id
        ];

        $response = $this->post('/api/posts', $postData, [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', ['title' => 'Test Post']);
    }

    public function test_show_single_post()
    {
        $post = Post::factory()->create();

        $response = $this->get("/api/posts/{$post->id}", [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['id' => $post->id]);
    }

    public function test_update_post()
    {
        $post = Post::factory()->create();
        $updateData = ['title' => 'Updated Title'];

        $response = $this->put("/api/posts/{$post->id}", $updateData, [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('posts', ['title' => 'Updated Title']);
    }

    public function test_delete_post()
    {
        $post = Post::factory()->create();

        $response = $this->delete("/api/posts/{$post->id}", [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    // Tests for ApiController (protected routes)
    public function test_get_ages_authenticated()
    {
        Sanctum::actingAs($this->user);

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
        Sanctum::actingAs($this->user);

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
        Sanctum::actingAs($this->user);

        $response = $this->get('/api/franchises', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);
    }

    public function test_get_franchises_with_age_id_authenticated()
    {
        Sanctum::actingAs($this->user);

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
        Sanctum::actingAs($this->user);

        $response = $this->get('/api/primes/1', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);
    }

    public function test_post_primes_authenticated()
    {
        Sanctum::actingAs($this->user);

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
        Sanctum::actingAs($this->user);

        $response = $this->get('/api/selection', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);
    }

    public function test_post_selection_authenticated()
    {
        Sanctum::actingAs($this->user);

        $response = $this->post('/api/selection/1/1', [], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);

        $response->assertStatus(200);
    }

    public function test_delete_selection_authenticated()
    {
        Sanctum::actingAs($this->user);

        $response = $this->delete('/api/selection/1/1', [], [
            'Accept' => 'application/json'
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
        Sanctum::actingAs($this->user);

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

    // Tests pour Profile routes
    public function test_post_profile_with_uid_authenticated()
    {
        Sanctum::actingAs($this->user);

        $response = $this->post('/api/profile/test-uid', [
            'name' => 'Test Profile',
            'data' => 'test'
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);

        $response->assertStatus(200);
    }

    public function test_get_profile_authenticated()
    {
        Sanctum::actingAs($this->user);

        $response = $this->get('/api/profile/1', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);
    }

    public function test_put_profile_authenticated()
    {
        Sanctum::actingAs($this->user);

        $response = $this->put('/api/profile/1', [
            'name' => 'Updated Profile'
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);

        $response->assertStatus(200);
    }

    public function test_delete_profile_authenticated()
    {
        Sanctum::actingAs($this->user);

        $response = $this->delete('/api/profile/1', [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);
    }

    public function test_profile_routes_unauthenticated()
    {
        // Test POST with UID
        $response = $this->post('/api/profile/test-uid', [
            'name' => 'Test Profile'
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);
        $response->assertStatus(401);

        // Test GET
        $response = $this->get('/api/profile/1', [
            'Accept' => 'application/json'
        ]);
        $response->assertStatus(401);

        // Test PUT
        $response = $this->put('/api/profile/1', [
            'name' => 'Updated Profile'
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ]);
        $response->assertStatus(401);

        // Test DELETE
        $response = $this->delete('/api/profile/1', [], [
            'Accept' => 'application/json'
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

    // Error 404 tests
    public function test_post_not_found()
    {
        $response = $this->get('/api/posts/999', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(404);
    }

    public function test_profile_not_found()
    {
        Sanctum::actingAs($this->user);

        $response = $this->get('/api/profile/999', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(404);
    }
}
