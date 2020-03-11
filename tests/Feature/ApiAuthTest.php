<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ApiAuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_signup_is_successful()
    {
        $password = Str::random(10);
        $email = $this->faker->email;

        // First check we cannot signup without all required fields
        $response = $this->json('post', route('api.auth.signup'), [
            'email' => $email,
            'name' => 'Tony Starks',
            'password' => $password,
        ]);

        $response->assertStatus(422);

        // Now do the actual signing up
        $response = $this->json('post', route('api.auth.signup'), [
            'email' => $email,
            'name' => 'Tony Starks',
            'password' => $password,
            'password_confirmation' => $password
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => $email]);

        // Test the login
        $response = $this->json('post', route('api.auth.login'), [
            'email' => $email,
            'password' => $password
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['access_token','token_type','expires_at']);
    }
}
