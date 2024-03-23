<?php

namespace Tests\Feature\Api\V1\Loan;

use App\Enums\BookUserStatusEnum;
use App\Enums\LoanStatusEnum;
use Database\Factories\BookUserFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RequestLoanEndpointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Test that request loan endpoint returns 201 status code and Loan Resource when loan is requested
     *
     * @return void
     */
    public function test_request_loan_endpoint_returns_201_status_code_and_loan_resource_when_loan_is_requested(): void
    {
        $user = UserFactory::new()->create();
        $user_2 = UserFactory::new()->create();
        $book_user = BookUserFactory::new()->create(attributes: [
            'user_id' => $user_2->id,
            'status' => BookUserStatusEnum::Available,
        ]);

        $response = $this->actingAs(user: $user)->postJson(
            uri: '/api/v1/loans',
            data: [
                'lender_id' => $book_user->user_id,
                'book_id' => $book_user->book_id,
                'from' => now()->toDateString(),
                'to' => now()->addDays(value: 7)->toDateString(),
            ]
        );

        $response->assertStatus(status: 201)
            ->assertJsonStructure([
                'id',
                'lender',
                'borrower',
                'book',
                'from',
                'to',
                'status',
            ]);

        $this->assertDatabaseHas(
            table: 'loans',
            data: [
                'lender_id' => $book_user->user_id,
                'borrower_id' => $user->id,
                'book_id' => $book_user->book_id,
                'from' => now()->toDateString(),
                'to' => now()->addDays(value: 7)->toDateString(),
                'status' => LoanStatusEnum::Requested,
            ]
        );
    }

    /**
     * @test
     *
     * Test that request loan endpoint returns 401 status code when user is not logged in
     * @return void
     */
    public function test_request_loan_endpoint_returns_401_status_code_when_user_is_not_logged_in(): void
    {
        $response = $this->postJson(
            uri: '/api/v1/loans',
            data: [
                'lender_id' => 1,
                'book_id' => 1,
                'from' => now()->toDateString(),
                'to' => now()->addDays(value: 7)->toDateString(),
            ]
        );

        $response->assertStatus(status: 401);
    }

    /**
     * @test
     *
     * Test that request loan endpoint returns 404 status code when book is not in the lender's library
     * @return void
     */
    public function test_request_loan_endpoint_returns_404_status_code_when_book_is_not_in_the_lenders_library(): void
    {
        $user = UserFactory::new()->create();
        $user_2 = UserFactory::new()->create();
        $book_user = BookUserFactory::new()->create(attributes: [
            'user_id' => 2,
            'status' => BookUserStatusEnum::Available,
        ]);

        $response = $this->actingAs(user: $user)->postJson(
            uri: '/api/v1/loans',
            data: [
                'lender_id' => $user_2->id,
                'book_id' => $book_user->book_id,
                'from' => now()->toDateString(),
                'to' => now()->addDays(value: 7)->toDateString(),
            ]
        );

        $response->assertStatus(status: 404);
    }

    /**
     * @test
     *
     * Test that request loan endpoint returns 400 status code when book is already borrowed
     * @return void
     */
    public function test_request_loan_endpoint_returns_400_status_code_when_book_is_already_borrowed(): void
    {
        $user = UserFactory::new()->create();
        $user_2 = UserFactory::new()->create();
        $book_user = BookUserFactory::new()->create(attributes: [
            'user_id' => $user_2->id,
            'status' => BookUserStatusEnum::Borrowed,
        ]);

        $response = $this->actingAs(user: $user)->postJson(
            uri: '/api/v1/loans',
            data: [
                'lender_id' => $book_user->user_id,
                'book_id' => $book_user->book_id,
                'from' => now()->toDateString(),
                'to' => now()->addDays(value: 7)->toDateString(),
            ]
        );

        $response->assertStatus(status: 400);
    }
}
