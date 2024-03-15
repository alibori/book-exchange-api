<?php

namespace Tests\Feature\Api\V1\Book;

use Database\Factories\AuthorFactory;
use Database\Factories\BookFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListBooksEndpointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Test that list books endpoint returns 200 status code and a paginated list of books
     *
     * @return void
     */
    public function test_list_books_endpoint_returns_200_status_code_and_a_paginated_list_of_books(): void
    {
        $user = UserFactory::new()->create();

        $response = $this->actingAs(user: $user)->getJson(
            uri: '/api/v1/books'
        );

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'author',
                        'category',
                    ]
                ],
                'pagination',
            ]);
    }

    /**
     * @test
     * Test that list books endpoint returns 401 status code when user is not logged in
     *
     * @return void
     */
    public function test_list_books_endpoint_returns_401_status_code_when_user_is_not_logged_in(): void
    {
        $response = $this->getJson(
            uri: '/api/v1/books'
        );

        $response->assertStatus(status: 401)
            ->assertJsonStructure([
                'message'
            ]);
    }

    /**
     * @test
     * Test that list books endpoint returns 200 status code and a paginated list of books filtered by title
     *
     * @return void
     */
    public function test_list_books_endpoint_returns_200_status_code_and_a_paginated_list_of_books_filtered_by_title(): void
    {
        $user = UserFactory::new()->create();

        BookFactory::new()->create(attributes: [
            'title' => 'The Hobbit',
        ]);

        $response = $this->actingAs(user: $user)->getJson(
            uri: '/api/v1/books?title=The%20Hobbit',
        );

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'author',
                        'category',
                    ]
                ],
                'pagination',
            ]);
    }

    /**
     * @test
     * Test that list books endpoint returns 200 status code and a paginated list of books filtered by author
     *
     * @return void
     */
    public function test_list_books_endpoint_returns_200_status_code_and_a_paginated_list_of_books_filtered_by_author(): void
    {
        $user = UserFactory::new()->create();

        $author = AuthorFactory::new()->create(attributes: [
            'name' => 'J.R.R. Tolkien',
        ]);

        BookFactory::new()->create(attributes: [
            'author_id' => $author->id,
        ]);

        $response = $this->actingAs(user: $user)->getJson(
            uri: '/api/v1/books?author=J.R.R.%20Tolkien',
        );

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'author',
                        'category',
                    ]
                ],
                'pagination',
            ]);
    }

    /**
     * @test
     * Test that list books endpoint returns 200 status code and a paginated list of books with 2 results per page
     *
     * @return void
     */
    public function test_list_books_endpoint_returns_200_status_code_and_a_paginated_list_of_books_with_2_results_per_page(): void
    {
        $user = UserFactory::new()->create();

        $response = $this->actingAs(user: $user)->getJson(
            uri: '/api/v1/books?results=2',
        );

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'author',
                        'category',
                    ]
                ],
                'pagination',
            ]);

        $this->assertCount(expectedCount: 2, haystack: $response->json(key: 'data'));
    }

    /**
     * @test
     * Test that list books endpoint returns 200 status code and the results of page 2
     *
     * @return void
     */
    public function test_list_books_endpoint_returns_200_status_code_and_the_results_of_page_2(): void
    {
        $user = UserFactory::new()->create();

        $response = $this->actingAs(user: $user)->getJson(
            uri: '/api/v1/books?results=2&page=2',
        );

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'author',
                        'category',
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
