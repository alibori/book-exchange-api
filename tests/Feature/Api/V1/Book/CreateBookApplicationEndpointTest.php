<?php

namespace Tests\Feature\Api\V1\Book;

use Database\Factories\AuthorFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateBookApplicationEndpointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * Test that create book application endpoint returns 201 status code and a success message when book application is created
     * @return void
     */
    public function test_create_book_application_endpoint_returns_201_status_code_and_a_success_message_when_book_application_is_created(): void
    {
        $user = UserFactory::new()->create();
        $author = AuthorFactory::new()->create();

        $response = $this->actingAs(user: $user)->postJson(
            uri: '/api/v1/books/applications',
            data: [
                'author_id' => $author->id,
                'title' => 'Book Title',
                'description' => 'Book Description',
            ]
        );

        $response->assertStatus(status: 201)
            ->assertJsonStructure([
                'id',
                'author',
                'author_name',
                'category',
                'title',
                'description',
                'status',
            ]);

        $this->assertDatabaseHas(
            table: 'book_applications',
            data: [
                'user_id' => $user->id,
                'author_id' => $author->id,
                'title' => 'Book Title',
                'description' => 'Book Description',
            ]
        );
    }

    /**
     * @test
     *
     * Test that create book application endpoint returns 401 status code when user is not logged in
     * @return void
     */
    public function test_create_book_application_endpoint_returns_401_status_code_when_user_is_not_logged_in(): void
    {
        $response = $this->postJson(
            uri: '/api/v1/books/applications',
            data: [
                'author_id' => 1,
                'title' => 'Book Title',
                'description' => 'Book Description',
            ]
        );

        $response->assertStatus(status: 401)
            ->assertJsonStructure([
                'message'
            ]);
    }
}
