<?php

namespace Tests\Feature\Api\V1\Book;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListCategoriesEndpointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Test that list categories endpoint returns 200 status code and a paginated list of categories
     *
     * @return void
     */
    public function test_list_categories_endpoint_returns_200_status_code_and_a_paginated_list_of_categories(): void
    {
        $user = UserFactory::new()->create();

        $response = $this->actingAs(user: $user)->getJson(
            uri: '/api/v1/categories'
        );

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                    ]
                ],
                'pagination',
            ]);
    }

    /**
     * @test
     * Test that list categories endpoint returns 401 status code when user is not logged in
     *
     * @return void
     */
    public function test_list_categories_endpoint_returns_401_status_code_when_user_is_not_logged_in(): void
    {
        $response = $this->getJson(
            uri: '/api/v1/categories'
        );

        $response->assertStatus(status: 401)
            ->assertJsonStructure([
                'message'
            ]);
    }

    /**
     * @test
     * Test that list categories endpoint returns 200 status code and a paginated list of categories with 2 results per page
     *
     * @return void
     */
    public function test_list_categories_endpoint_returns_200_status_code_and_a_paginated_list_of_categories_with_2_results_per_page(): void
    {
        $user = UserFactory::new()->create();

        $response = $this->actingAs(user: $user)->getJson(
            uri: '/api/v1/categories?page=1&results=2'
        );

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                    ]
                ],
                'pagination',
            ])
            ->assertJsonCount(count: 2, key: 'data');
    }

    /**
     * @test
     * Test that list categories endpoint returns 200 status code and the results of page 2
     *
     * @return void
     */
    public function test_list_categories_endpoint_returns_200_status_code_and_the_results_of_page_2(): void
    {
        $user = UserFactory::new()->create();

        $response = $this->actingAs(user: $user)->getJson(
            uri: '/api/v1/categories?page=2'
        );

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                    ]
                ],
                'pagination',
            ])

            ->assertJson([
                'pagination' => [
                    'current_page' => 2,
                ]
            ]);
    }
}
