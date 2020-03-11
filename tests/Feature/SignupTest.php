<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class SignupTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_signup_is_successful()
    {
        $this->withoutMiddleware();

        $password = Str::random(10);
        $email = $this->faker->email;

        // First check we cannot signup without all required fields
        $response = $this->json('post', route('auth.signup'), [
            'email' => $email,
            'name' => 'Tony Starks',
            'password' => $password,
        ]);

        $response->assertStatus(422);

        // Now do the actual signing up
        $response = $this->json('post', route('auth.signup'), [
            'email' => $email,
            'name' => 'Tony Starks',
            'password' => $password,
            'password_confirmation' => $password
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => $email]);
    }
}
