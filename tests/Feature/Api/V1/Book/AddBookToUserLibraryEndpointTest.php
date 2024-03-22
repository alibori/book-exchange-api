<?php

namespace Tests\Feature\Api\V1\Book;

use App\Enums\BookUserStatusEnum;
use App\Models\Book;
use Database\Factories\BookUserFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddBookToUserLibraryEndpointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Test that add book to user library endpoint returns 201 status code and a success message when book is added to user library
     *
     * @return void
     */
    public function test_add_book_to_user_library_endpoint_returns_201_status_code_and_a_success_message_when_book_is_added_to_user_library(): void
    {
        $user = UserFactory::new()->create();

        $response = $this->actingAs(user: $user)->postJson(
            uri: '/api/v1/books',
            data: [
                'book_id' => 1,
                'quantity' => 1,
            ]
        );

        $response->assertStatus(status: 201)
            ->assertJsonStructure([
                'message',
            ]);

        $this->assertDatabaseHas(
            table: 'book_user',
            data: [
                'user_id' => $user->id,
                'book_id' => 1,
                'quantity' => 1,
                'status' => BookUserStatusEnum::Available
            ]
        );
    }

    /**
     * @test
     * Test that add book to user library endpoint returns 401 status code when user is not logged in
     *
     * @return void
     */
    public function test_add_book_to_user_library_endpoint_returns_401_status_code_when_user_is_not_logged_in(): void
    {
        $response = $this->postJson(
            uri: '/api/v1/books',
            data: [
                'book_id' => 1,
                'quantity' => 1,
            ]
        );

        $response->assertStatus(status: 401);
    }

    /**
     * @test
     * Test that add book to user library endpoint returns 400 status code when book is already in user library
     *
     * @return void
     */
    public function test_add_book_to_user_library_endpoint_returns_400_status_code_when_book_is_already_in_user_library(): void
    {
        $user = UserFactory::new()->create();

        $book_user = BookUserFactory::new()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs(user: $user)->postJson(
            uri: '/api/v1/books',
            data: [
                'book_id' => $book_user->book_id,
                'quantity' => 1,
            ]
        );

        $response->assertStatus(status: 400);
    }
}
