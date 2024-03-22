<?php

namespace Tests\Feature\Api\V1\Book;

use App\Enums\BookUserStatusEnum;
use Database\Factories\BookUserFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateBookFromUserLibraryEndpointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Test that update book from user library endpoint returns 200 status code and a success message when book is updated in user library
     *
     * @return void
     */
    public function test_update_book_from_user_library_endpoint_returns_200_status_code_and_a_success_message_when_book_is_updated_in_user_library(): void
    {
        $user = UserFactory::new()->create();
        $book_user = BookUserFactory::new()->create([
            'user_id' => $user->id,
            'quantity' => 1,
            'status' => BookUserStatusEnum::Available
        ]);

        $response = $this->actingAs(user: $user)->putJson(
            uri: '/api/v1/books/' . $book_user->book_id,
            data: [
                'quantity' => 2
            ]
        );

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'message',
            ]);

        $this->assertDatabaseHas(
            table: 'book_user',
            data: [
                'user_id' => $user->id,
                'book_id' => $book_user->book_id,
                'quantity' => 2
            ]
        );
    }

    /**
     * @test
     * Test that update book from user library endpoint returns 401 status code when user is not logged in
     *
     * @return void
     */
    public function test_update_book_from_user_library_endpoint_returns_401_status_code_when_user_is_not_logged_in(): void
    {
        $response = $this->putJson(
            uri: '/api/v1/books/1',
            data: [
                'quantity' => 2
            ]
        );

        $response->assertStatus(status: 401);
    }

    /**
     * @test
     * Test that update book from user library endpoint returns 404 status code when book is not in user library
     *
     * @return void
     */
    public function test_update_book_from_user_library_endpoint_returns_404_status_code_when_book_is_not_in_user_library(): void
    {
        $user = UserFactory::new()->create();

        $response = $this->actingAs(user: $user)->putJson(
            uri: '/api/v1/books/1',
            data: [
                'quantity' => 2
            ]
        );

        $response->assertStatus(status: 404);
    }
}
