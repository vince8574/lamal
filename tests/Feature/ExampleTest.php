<?php

namespace Tests\Feature;

use App\Models\AnonymousUser;
use App\Models\Card;
use App\Models\User;
use App\Models\Post;
use App\Models\Prime;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;


class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    /* protected function setUp(): void
    {
        parent::setUp();

        // Create Laravel's application for tests
        $this->createApplication();

        $this->user = User::factory()->create();
    }*/

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
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->get('/api/profile/999', [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(404);
    }
}

class LoginThrottleTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Créer un utilisateur de test
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('correct_password')
        ]);
    }

    protected function tearDown(): void
    {
        // Nettoyer le rate limiter après chaque test
        RateLimiter::clear('login_attempts:test@example.com');
        RateLimiter::clear('login_attempts:throttle@example.com');

        parent::tearDown();
    }

    /** @test */
    public function test_successful_login_resets_throttle_counter()
    {
        // Faire 2 tentatives échouées
        $this->makeFailedLoginAttempt();
        $this->makeFailedLoginAttempt();

        // Vérifier qu'il y a 2 tentatives
        $this->assertEquals(2, RateLimiter::attempts('login_attempts:test@example.com'));

        // Faire une tentative réussie
        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'correct_password'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['user', 'token']);

        // Vérifier que le compteur est remis à zéro
        $this->assertEquals(0, RateLimiter::attempts('login_attempts:test@example.com'));
    }

    /** @test */
    public function test_failed_login_increments_attempts_counter()
    {
        // Première tentative échouée
        $response = $this->makeFailedLoginAttempt();

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Identifiants invalides.',
            'remaining_attempts' => 4
        ]);

        // Deuxième tentative échouée
        $response = $this->makeFailedLoginAttempt();

        $response->assertJson([
            'remaining_attempts' => 3
        ]);

        // Vérifier le compteur
        $this->assertEquals(2, RateLimiter::attempts('login_attempts:test@example.com'));
    }

    /** @test */
    public function test_warning_message_appears_when_few_attempts_remaining()
    {
        // Faire 3 tentatives échouées pour arriver à 2 tentatives restantes
        $this->makeFailedLoginAttempt();
        $this->makeFailedLoginAttempt();
        $this->makeFailedLoginAttempt();

        $response = $this->makeFailedLoginAttempt();

        $response->assertStatus(401);
        $response->assertJsonStructure([
            'message',
            'remaining_attempts',
            'warning'
        ]);

        $responseData = $response->json();
        $this->assertEquals(1, $responseData['remaining_attempts']);
        $this->assertStringContainsString('Attention', $responseData['warning']);
    }

    /** @test */
    public function test_user_gets_locked_after_5_failed_attempts()
    {
        // Faire 5 tentatives échouées
        for ($i = 0; $i < 5; $i++) {
            $this->makeFailedLoginAttempt();
        }

        // La 6ème tentative doit être bloquée
        $response = $this->makeFailedLoginAttempt();

        $response->assertStatus(429);
        $response->assertJsonStructure([
            'message',
            'lockout',
            'remaining_seconds',
            'retry_after'
        ]);

        $responseData = $response->json();
        $this->assertTrue($responseData['lockout']);
        $this->assertGreaterThan(0, $responseData['remaining_seconds']);
        $this->assertLessThanOrEqual(60, $responseData['remaining_seconds']);
    }

    /** @test */
    public function test_lockout_prevents_further_attempts()
    {
        // Déclencher le lockout
        for ($i = 0; $i < 5; $i++) {
            $this->makeFailedLoginAttempt();
        }

        // Tenter plusieurs fois pendant le lockout
        for ($i = 0; $i < 3; $i++) {
            $response = $this->makeFailedLoginAttempt();
            $response->assertStatus(429);
            $response->assertJson(['lockout' => true]);
        }
    }

    /** @test */
    public function test_correct_credentials_are_also_blocked_during_lockout()
    {
        // Déclencher le lockout avec de mauvais identifiants
        for ($i = 0; $i < 5; $i++) {
            $this->makeFailedLoginAttempt();
        }

        // Essayer avec les bons identifiants pendant le lockout
        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'correct_password'
        ]);

        $response->assertStatus(429);
        $response->assertJson(['lockout' => true]);
    }

    /** @test */
    public function test_different_users_have_separate_throttle_counters()
    {
        // Créer un second utilisateur
        $user2 = User::factory()->create([
            'email' => 'user2@example.com',
            'password' => Hash::make('password2')
        ]);

        // Faire échouer 5 tentatives pour le premier utilisateur
        for ($i = 0; $i < 5; $i++) {
            $this->makeFailedLoginAttempt();
        }

        // Le premier utilisateur doit être bloqué
        $response = $this->makeFailedLoginAttempt();
        $response->assertStatus(429);

        // Le second utilisateur ne doit pas être affecté
        $response = $this->postJson('/api/login', [
            'email' => 'user2@example.com',
            'password' => 'wrong_password'
        ]);

        $response->assertStatus(401);
        $response->assertJson(['remaining_attempts' => 4]);
    }

    /** @test */
    public function test_throttle_message_formatting()
    {
        // Déclencher le lockout
        for ($i = 0; $i < 5; $i++) {
            $this->makeFailedLoginAttempt();
        }

        $response = $this->makeFailedLoginAttempt();
        $responseData = $response->json();

        // Vérifier que le message contient des informations sur le temps
        $this->assertStringContainsString('temporairement bloqué', $responseData['message']);
        $this->assertArrayHasKey('retry_after', $responseData);

        // Vérifier le format ISO de retry_after
        $this->assertMatchesRegularExpression('/\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}/', $responseData['retry_after']);
    }

    /** @test */
    public function test_login_status_endpoint_shows_current_attempts()
    {
        // Faire quelques tentatives échouées
        $this->makeFailedLoginAttempt();
        $this->makeFailedLoginAttempt();

        // Tester l'endpoint de statut (si implémenté)
        $response = $this->postJson('/api/auth/login-status', [
            'email' => 'test@example.com'
        ]);

        if ($response->status() !== 404) { // Si l'endpoint existe
            $response->assertStatus(200);
            $response->assertJson([
                'locked' => false,
                'attempts_made' => 2,
                'remaining_attempts' => 3
            ]);
        }
    }

    /**
     * Effectue une tentative de connexion échouée
     */
    private function makeFailedLoginAttempt()
    {
        return $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'wrong_password'
        ]);
    }

    /**
     * Test de performance - vérifier que le throttling n'impacte pas les performances
     * 
     * @test
     */
    public function test_throttling_performance()
    {
        $startTime = microtime(true);

        // Faire plusieurs tentatives rapides
        for ($i = 0; $i < 10; $i++) {
            $this->makeFailedLoginAttempt();
        }

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        // Vérifier que ça ne prend pas plus de 2 secondes
        $this->assertLessThan(2.0, $executionTime, 'Le throttling ne doit pas impacter significativement les performances');
    }

    /**
     * Test edge case - tentative avec email inexistant
     * 
     * @test  
     */
    public function test_throttling_with_nonexistent_email()
    {
        // Faire 5 tentatives avec un email qui n'existe pas
        for ($i = 0; $i < 5; $i++) {
            $response = $this->postJson('/api/login', [
                'email' => 'nonexistent@example.com',
                'password' => 'any_password'
            ]);

            if ($i < 4) {
                $response->assertStatus(401);
            }
        }

        // La 6ème tentative doit être throttlée
        $response = $this->postJson('/api/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'any_password'
        ]);

        $response->assertStatus(429);
    }
}
