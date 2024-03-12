<?php

namespace Tests\Feature\Api\V1\User;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateUserEndpointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Test that update user endpoint returns 200 status code and user information when user is updated
     *
     * @return void
     */
    public function test_update_user_endpoint_returns_200_status_code_and_user_information_when_user_is_updated(): void
    {
        $user = UserFactory::new()->create(attributes: [
            'name' => 'John',
            'surname' => 'Doe',
        ]);

        $this->assertDatabaseHas(table: 'users', data: [
            'name' => 'John',
            'surname' => 'Doe',
        ]);

        $response = $this->actingAs(user: $user)
            ->putJson(
                uri: '/api/v1/users/' . $user->id,
                data: [
                    'name' => 'John',
                    'surname' => 'Doe Jr.',
                ]
            );

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'id',
                'name',
                'surname',
            ]);

        $this->assertDatabaseHas(table: 'users', data: [
            'name' => 'John',
            'surname' => 'Doe Jr.',
        ]);
    }

    /**
     * @test
     * Test that update user endpoint returns 401 status code when user is not logged in
     *
     * @return void
     */
    public function test_update_user_endpoint_returns_401_status_code_when_user_is_not_logged_in(): void
    {
        $response = $this->putJson(
            uri: '/api/v1/users/1',
            data: [
                'name' => 'John',
                'surname' => 'Doe Jr.',
            ]
        );

        $response->assertStatus(status: 401)
            ->assertJsonStructure([
                'message'
            ]);
    }

    /**
     * @test
     * Test that update user endpoint returns 403 status code when user is trying to update another user or non-existent one
     *
     * @return void
     */
    public function test_update_user_endpoint_returns_403_status_code_when_user_is_trying_to_update_another_user_or_non_existent_one(): void
    {
        $user = UserFactory::new()->create();
        $another_user = UserFactory::new()->create();

        $response = $this->actingAs(user: $user)
            ->putJson(
                uri: '/api/v1/users/' . $another_user->id,
                data: [
                    'name' => 'John',
                    'surname' => 'Doe Jr.',
                ]
            );

        $response->assertStatus(status: 403)
            ->assertJsonStructure([
                'error'
            ]);
    }
}
