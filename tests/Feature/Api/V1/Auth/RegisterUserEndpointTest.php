<?php

namespace Tests\Feature\Api\V1\Auth;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterUserEndpointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Test that register user endpoint returns 201 status code and user is created on the database
     *
     * @return void
     */
    public function test_register_user_endpoint_returns_201_status_code_and_user_is_created_on_the_database(): void
    {
        $response = $this->postJson(
            uri: '/api/v1/auth/register',
            data: [
                'name' => 'John',
                'surname' => 'Doe',
                'email' => 'john.doe@test.com',
                'password' => 'password',
                'password_confirmation' => 'password',
                'phone' => '123456789',
                'address' => '123 Main St',
                'city' => 'Springfield',
                'country' => 'USA',
                'postal_code' => '12345',
            ]
        );

        $response->assertStatus(status: 201);
        $this->assertDatabaseHas(
            table: 'users',
            data: [
                'name' => 'John',
                'surname' => 'Doe',
                'email' => 'john.doe@test.com',
                'phone' => '123456789',
                'address' => '123 Main St',
                'city' => 'Springfield',
                'country' => 'USA',
                'postal_code' => '12345',
            ]
        );
    }

    /**
     * @test
     * Test that register user endpoint returns 422 status code and validation error when email is already in use
     *
     * @return void
     */
    public function test_register_user_endpoint_returns_422_status_code_and_validation_error_when_email_is_already_in_use(): void
    {
        $user = UserFactory::new()->create();

        $response = $this->postJson(
            uri: '/api/v1/auth/register',
            data: [
                'name' => 'John',
                'surname' => 'Doe',
                'email' => $user->email,
                'password' => 'password',
                'password_confirmation' => 'password',
                'phone' => '123456789',
                'address' => '123 Main St',
                'city' => 'Springfield',
                'country' => 'USA',
                'postal_code' => '12345',
            ]
        );

        $response->assertStatus(status: 422)
            ->assertJsonStructure(
                structure: [
                    'message',
                    'errors' => [
                        'email',
                    ],
                ]
            );
    }

    /**
     * @test
     * Test that register user endpoint returns 422 status code when validation fails
     *
     * @return void
     */
    public function test_register_user_endpoint_returns_422_status_code_when_validation_fails(): void
    {
        $response = $this->postJson(
            uri: '/api/v1/auth/register',
        );

        $response->assertStatus(status: 422)
            ->assertJsonStructure(
                structure: [
                    'message',
                    'errors' => [
                        'name',
                        'surname',
                        'email',
                        'password',
                        'phone',
                        'address',
                        'city',
                        'country',
                        'postal_code',
                    ],
                ]
            );
    }
}
