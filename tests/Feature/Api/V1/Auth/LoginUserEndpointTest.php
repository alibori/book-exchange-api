<?php

namespace Tests\Feature\Api\V1\Auth;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginUserEndpointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Test that login user endpoint returns 200 status code and user is logged in
     *
     * @return void
     */
    public function test_login_user_endpoint_returns_200_status_code_and_user_is_logged_in(): void
    {
        $user = UserFactory::new()->create([
            'password' => Hash::make('password')
        ]);

        $response = $this->postJson(
            uri: '/api/v1/auth/login',
            data: [
                'email' => $user->email,
                'password' => 'password'
            ]
        );

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'message',
                'token'
            ]);
    }

    /**
     * @test
     * Test that login user endpoint returns 401 status code and validation error when email or password are invalid
     *
     * @return void
     */
    public function test_login_user_endpoint_returns_401_status_code_and_validation_error_when_email_or_password_are_invalid(): void
    {
        $response = $this->postJson(
            uri: '/api/v1/auth/login',
            data: [
                'email' => 'fake@email.com',
                'password' => 'fakepassword'
            ]
        );

        $response->assertStatus(status: 401)
            ->assertJsonStructure([
                'error'
            ]);
    }

    /**
     * @test
     * Test that login user endpoint returns 422 status code when validation fails
     *
     * @return void
     */
    public function test_login_user_endpoint_returns_422_status_code_when_validation_fails(): void
    {
        $response = $this->postJson(
            uri: '/api/v1/auth/login',
            data: [
                'email' => 'fakeemail.com',
                'password' => 'fakepassword'
            ]
        );

        $response->assertStatus(status: 422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email',
                ],
            ]);
    }
}
