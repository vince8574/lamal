<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Actions\CreateAnonymousUserAction;
use App\Actions\CreateProfileAction;

class ProfileTest extends TestCase
{
    // Tests pour Profile routes
    public function test_un_profil_peut_etre_cree_sans_compte_anonyme_existant()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/profile', [
            'name' => 'Test Profile',
            'city' => 21,
        ]);
        $response->assertStatus(201);

        $response->assertJson(
            fn(AssertableJson $json) => $json->has('uid')->has('profile')
        );
    }

    public function test_un_profil_peut_etre_cree_avec_compte_anonyme_existant()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $anonymous = CreateAnonymousUserAction::make()->execute();


        $response = $this->postJson(
            '/api/profile',
            [
                'name' => 'Test Profile',
                'city' => 21,
            ],
            [
                'X-ANONYMOUS-TOKEN' => $anonymous->token
            ]
        );
        $response->assertStatus(201);

        $response->assertJsonPath('uid', $anonymous->token);
        $response->assertJson(
            fn(AssertableJson $json) => $json->has('uid')->has('profile')
        );
    }


    public function test_get_profile_authenticated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $anonymous = CreateAnonymousUserAction::make()->execute();

        $name = 'testName';
        $city = 10;

        $profile = CreateProfileAction::make($name, $city, $anonymous);
        //   dump($anonymous);
        $response = $this->get(
            '/api/profile/' . $profile->id,
            [
                'Accept' => 'application/json',
                'X-ANONYMOUS-TOKEN' => $anonymous->token
            ]
        );

        $response->assertStatus(200);
    }

    public function test_put_profile_authenticated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $anonymous = CreateAnonymousUserAction::make()->execute();

        $name = 'testNamePut';
        $city = 10;
        $profile = CreateProfileAction::make($name, $city, $anonymous);

        $response = $this->putJson(
            '/api/profile/' . $profile->id,
            [
                'name' => 'Updated Profile',
                'city' => 22,
            ],
            [
                'X-ANONYMOUS-TOKEN' => $anonymous->token
            ]
        );

        $response->assertStatus(200);

        $response->assertJsonPath('uid', $anonymous->token);
        $response->assertJson(
            fn(AssertableJson $json) => $json->has('uid')->has('profile')
        );
    }

    public function test_delete_profile_authenticated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $anonymous = CreateAnonymousUserAction::make()->execute();

        $name = 'testNamePut';
        $city = 10;
        $profile = CreateProfileAction::make($name, $city, $anonymous);

        $response = $this->delete('/api/profile/' . $profile->id, [], [
            'X-ANONYMOUS-TOKEN' => $anonymous->token
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
}
