<?php

namespace Tests\Feature\Api\V1\User;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListUsersEndpointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Test that list users endpoint returns 200 status code and a paginated list of users
     *
     * @return void
     */
    public function test_list_users_endpoint_returns_200_status_code_and_a_paginated_list_of_users(): void
    {
        $user = UserFactory::new()->create();

        $response = $this->actingAs($user)
            ->getJson(
                uri: '/api/v1/users'
            );

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                    ]
                ],
                'pagination',
            ]);
    }

    /**
     * @test
     * Test that list users endpoint returns 401 status code when user is not logged in
     *
     * @return void
     */
    public function test_list_users_endpoint_returns_401_status_code_when_user_is_not_logged_in(): void
    {
        $response = $this->getJson(
            uri: '/api/v1/users'
        );

        $response->assertStatus(status: 401)
            ->assertJsonStructure([
                'message'
            ]);
    }

    /**
     * @test
     * Test that list users endpoint returns 200 status code with a paginated list of users with 2 results per page
     *
     * @return void
     */
    public function test_list_users_endpoint_returns_200_status_code_with_a_paginated_list_of_users_with_2_results_per_page(): void
    {
        $user = UserFactory::new()->create();

        $response = $this->actingAs($user)
            ->getJson(
                uri: '/api/v1/users'. '?results=2',
            );

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                    ]
                ],
                'pagination',
            ]);

        $this->assertCount(expectedCount: 2, haystack: $response->json()['data']);
    }

    /**
     * @test
     * Test that list users endpoint returns 200 status code with the results of page 2
     *
     * @return void
     */
    public function test_list_users_endpoint_returns_200_status_code_with_the_results_of_page_2(): void
    {
        $user = UserFactory::new()->create();

        $response = $this->actingAs($user)
            ->getJson(
                uri: '/api/v1/users'. '?results=2&page=2',
            );

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                    ]
                ],
                'pagination' => [
                    'current_page',
                ]
            ])
            ->assertJson([
                'pagination' => [
                    'current_page' => 2,
                ]
            ]);
    }

    /**
     * @test
     * Test that list users endpoint returns 200 status code and authenticated user is not in the list
     *
     * @return void
     */
    public function test_list_users_endpoint_returns_200_status_code_and_authenticated_user_is_not_in_the_list(): void
    {
        $user = UserFactory::new()->create();

        $response = $this->actingAs($user)
            ->getJson(
                uri: '/api/v1/users'
            );

        $response->assertStatus(status: 200)
            ->assertJsonMissing([
                'id' => $user->id,
            ]);
    }
}
