<?php

namespace Tests\Feature\Api\V1\Loan;

use App\Enums\BookUserStatusEnum;
use App\Enums\LoanStatusEnum;
use Database\Factories\BookUserFactory;
use Database\Factories\LoanFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateLoanEndpointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Test that update loan endpoint returns 200 status code and success message when Loan is cancelled by the borrower
     *
     * @return void
     */
    public function test_update_loan_endpoint_returns_200_status_code_and_success_message_when_loan_is_cancelled_by_the_borrower(): void
    {
        $user = UserFactory::new()->create();
        $user_2 = UserFactory::new()->create();
        $book_user = BookUserFactory::new()->create(attributes: [
            'user_id' => $user_2->id,
            'status' => BookUserStatusEnum::Available,
        ]);
        $loan = LoanFactory::new()->create(attributes: [
            'lender_id' => $book_user->user_id,
            'borrower_id' => $user->id,
            'book_id' => $book_user->book_id,
            'status' => LoanStatusEnum::Requested,
        ]);

        $response = $this->actingAs(user: $user)->putJson(
            uri: "/api/v1/loans/{$loan->id}",
            data: [
                'status' => LoanStatusEnum::Cancelled,
            ]
        );

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'message',
            ]);

        $this->assertDatabaseHas(
            table: 'loans',
            data: [
                'id' => $loan->id,
                'status' => LoanStatusEnum::Cancelled,
            ]
        );
    }

    /**
     * @test
     * Test that update loan endpoint returns 200 status code and success message when Loan is accepted by the lender
     *
     * @return void
     */
    public function test_update_loan_endpoint_returns_200_status_code_and_success_message_when_loan_is_accepted_by_the_lender(): void
    {
        $user = UserFactory::new()->create();
        $user_2 = UserFactory::new()->create();
        $book_user = BookUserFactory::new()->create(attributes: [
            'user_id' => $user_2->id,
            'status' => BookUserStatusEnum::Available,
        ]);
        $loan = LoanFactory::new()->create(attributes: [
            'lender_id' => $book_user->user_id,
            'borrower_id' => $user->id,
            'book_id' => $book_user->book_id,
            'status' => LoanStatusEnum::Requested,
        ]);

        $response = $this->actingAs(user: $user_2)->putJson(
            uri: "/api/v1/loans/{$loan->id}",
            data: [
                'status' => LoanStatusEnum::Approved,
            ]
        );

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'message',
            ]);

        $this->assertDatabaseHas(
            table: 'loans',
            data: [
                'id' => $loan->id,
                'status' => LoanStatusEnum::Approved,
            ]
        );
    }

    /**
     * @test
     * Test that update loan endpoint returns 200 status code and success message when Loan is rejected by the lender
     *
     * @return void
     */
    public function test_update_loan_endpoint_returns_200_status_code_and_success_message_when_loan_is_rejected_by_the_lender(): void
    {
        $user = UserFactory::new()->create();
        $user_2 = UserFactory::new()->create();
        $book_user = BookUserFactory::new()->create(attributes: [
            'user_id' => $user_2->id,
            'status' => BookUserStatusEnum::Available,
        ]);
        $loan = LoanFactory::new()->create(attributes: [
            'lender_id' => $book_user->user_id,
            'borrower_id' => $user->id,
            'book_id' => $book_user->book_id,
            'status' => LoanStatusEnum::Requested,
        ]);

        $response = $this->actingAs(user: $user_2)->putJson(
            uri: "/api/v1/loans/{$loan->id}",
            data: [
                'status' => LoanStatusEnum::Rejected,
            ]
        );

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'message',
            ]);

        $this->assertDatabaseHas(
            table: 'loans',
            data: [
                'id' => $loan->id,
                'status' => LoanStatusEnum::Rejected,
            ]
        );
    }

    /**
     * @test
     * Test that update loan endpoint returns 404 status code when Loan is not found
     *
     * @return void
     */
    public function test_update_loan_endpoint_returns_404_status_code_when_loan_is_not_found(): void
    {
        $user = UserFactory::new()->create();

        $response = $this->actingAs(user: $user)->putJson(
            uri: '/api/v1/loans/1',
            data: [
                'status' => LoanStatusEnum::Cancelled,
            ]
        );

        $response->assertStatus(status: 404);
    }

    /**
     * @test
     * Test that update loan endpoint returns 403 status code when Loan is accepted by lender and the borrower tries to cancel it
     *
     * @return void
     */
    public function test_update_loan_endpoint_returns_403_status_code_when_loan_is_accepted_by_lender_and_the_borrower_tries_to_cancel_it(): void
    {
        $user = UserFactory::new()->create();
        $user_2 = UserFactory::new()->create();
        $book_user = BookUserFactory::new()->create(attributes: [
            'user_id' => $user_2->id,
            'status' => BookUserStatusEnum::Available,
        ]);
        $loan = LoanFactory::new()->create(attributes: [
            'lender_id' => $book_user->user_id,
            'borrower_id' => $user->id,
            'book_id' => $book_user->book_id,
            'status' => LoanStatusEnum::Approved,
        ]);

        $response = $this->actingAs(user: $user)->putJson(
            uri: "/api/v1/loans/{$loan->id}",
            data: [
                'status' => LoanStatusEnum::Cancelled,
            ]
        );

        $response->assertStatus(status: 403);
    }

    /**
     * @test
     * Test that update loan endpoint returns 403 status code when authenticated user is not the lender or borrower
     *
     * @return void
     */
    public function test_update_loan_endpoint_returns_403_status_code_when_authenticated_user_is_not_the_lender_or_borrower(): void
    {
        $user = UserFactory::new()->create();
        $user_2 = UserFactory::new()->create();
        $user_3 = UserFactory::new()->create();
        $book_user = BookUserFactory::new()->create(attributes: [
            'user_id' => $user_2->id,
            'status' => BookUserStatusEnum::Available,
        ]);
        $loan = LoanFactory::new()->create(attributes: [
            'lender_id' => $book_user->user_id,
            'borrower_id' => $user->id,
            'book_id' => $book_user->book_id,
            'status' => LoanStatusEnum::Requested,
        ]);

        $response = $this->actingAs(user: $user_3)->putJson(
            uri: "/api/v1/loans/{$loan->id}",
            data: [
                'status' => LoanStatusEnum::Cancelled,
            ]
        );

        $response->assertStatus(status: 403);
    }

    /**
     * @test
     * Test that update loan endpoint returns 404 status code when the book is not in the lender's library
     *
     * @return void
     */
    public function test_update_loan_endpoint_returns_404_status_code_when_the_book_is_not_in_the_lenders_library(): void
    {
        $user = UserFactory::new()->create();
        $user_2 = UserFactory::new()->create();
        $book_user = BookUserFactory::new()->create(attributes: [
            'user_id' => $user_2->id,
            'book_id' => 1,
            'status' => BookUserStatusEnum::Available,
        ]);
        $loan = LoanFactory::new()->create(attributes: [
            'lender_id' => $user_2->id,
            'borrower_id' => $user->id,
            'book_id' => 2,
            'status' => LoanStatusEnum::Requested,
        ]);

        $response = $this->actingAs(user: $user)->putJson(
            uri: "/api/v1/loans/{$loan->id}",
            data: [
                'status' => LoanStatusEnum::Cancelled,
            ]
        );

        $response->assertStatus(status: 404);
    }

    /**
     * @test
     * Test that update loan endpoint returns 403 status code when borrower tries to update with a status different from Cancelled
     *
     * @return void
     */
    public function test_update_loan_endpoint_returns_403_status_code_when_borrower_tries_to_update_with_a_status_different_from_cancelled(): void
    {
        $user = UserFactory::new()->create();
        $user_2 = UserFactory::new()->create();
        $book_user = BookUserFactory::new()->create(attributes: [
            'user_id' => $user_2->id,
            'status' => BookUserStatusEnum::Available,
        ]);
        $loan = LoanFactory::new()->create(attributes: [
            'lender_id' => $book_user->user_id,
            'borrower_id' => $user->id,
            'book_id' => $book_user->book_id,
            'status' => LoanStatusEnum::Requested,
        ]);

        $response = $this->actingAs(user: $user)->putJson(
            uri: "/api/v1/loans/{$loan->id}",
            data: [
                'status' => LoanStatusEnum::Approved,
            ]
        );

        $response->assertStatus(status: 403);
    }

    /**
     * @test
     * Test that update loan endpoint returns 403 status code when lender tries to update with a status different from Approved, Rejected or Returned
     *
     * @return void
     */
    public function test_update_loan_endpoint_returns_403_status_code_when_lender_tries_to_update_with_a_status_different_from_approved_rejected_or_returned(): void
    {
        $user = UserFactory::new()->create();
        $user_2 = UserFactory::new()->create();
        $book_user = BookUserFactory::new()->create(attributes: [
            'user_id' => $user_2->id,
            'status' => BookUserStatusEnum::Available,
        ]);
        $loan = LoanFactory::new()->create(attributes: [
            'lender_id' => $user_2->id,
            'borrower_id' => $user->id,
            'book_id' => $book_user->book_id,
            'status' => LoanStatusEnum::Requested,
        ]);

        $response = $this->actingAs(user: $user_2)->putJson(
            uri: "/api/v1/loans/{$loan->id}",
            data: [
                'status' => LoanStatusEnum::Cancelled,
            ]
        );

        $response->assertStatus(status: 403);
    }

    /**
     * @test
     * Test that update loan endpoint returns 403 status code when lender tries to update with a status Approved and the book is borrowed
     *
     * @return void
     */
    public function test_update_loan_endpoint_returns_403_status_code_when_lender_tries_to_update_with_a_status_approved_and_the_book_is_borrowed(): void
    {
        $user = UserFactory::new()->create();
        $user_2 = UserFactory::new()->create();
        $book_user = BookUserFactory::new()->create(attributes: [
            'user_id' => $user_2->id,
            'status' => BookUserStatusEnum::Borrowed,
        ]);
        $loan = LoanFactory::new()->create(attributes: [
            'lender_id' => $user_2->id,
            'borrower_id' => $user->id,
            'book_id' => $book_user->book_id,
            'status' => LoanStatusEnum::Requested,
        ]);

        $response = $this->actingAs(user: $user_2)->putJson(
            uri: "/api/v1/loans/{$loan->id}",
            data: [
                'status' => LoanStatusEnum::Approved,
            ]
        );

        $response->assertStatus(status: 403);
    }

    /**
     * @test
     * Test that update loan endpoint returns 200 status code and BookUser status is updated to Available when Loan is returned
     *
     * @return void
     */
    public function test_update_loan_endpoint_returns_200_status_code_and_book_user_status_is_updated_to_available_when_loan_is_returned(): void
    {
        $user = UserFactory::new()->create();
        $user_2 = UserFactory::new()->create();
        $book_user = BookUserFactory::new()->create(attributes: [
            'user_id' => $user_2->id,
            'status' => BookUserStatusEnum::Borrowed,
            'quantity' => 1,
        ]);
        $loan = LoanFactory::new()->create(attributes: [
            'lender_id' => $user_2->id,
            'borrower_id' => $user->id,
            'book_id' => $book_user->book_id,
            'status' => LoanStatusEnum::Approved,
        ]);

        $response = $this->actingAs(user: $user_2)->putJson(
            uri: "/api/v1/loans/{$loan->id}",
            data: [
                'status' => LoanStatusEnum::Returned,
            ]
        );

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'message',
            ]);

        $this->assertDatabaseHas(
            table: 'loans',
            data: [
                'id' => $loan->id,
                'status' => LoanStatusEnum::Returned,
            ]
        );

        $this->assertDatabaseHas(
            table: 'book_user',
            data: [
                'id' => $book_user->id,
                'status' => BookUserStatusEnum::Available,
            ]
        );
    }

    /**
     * @test
     * Test that update loan endpoint returns 200 status code and BookUser status is updated to Borrowed when Loan is approved and the BookUser has a quantity 1
     *
     * @return void
     */
    public function test_update_loan_endpoint_returns_200_status_code_and_book_user_status_is_updated_to_borrowed_when_loan_is_approved_and_the_book_user_has_a_quantity_1(): void
    {
        $user = UserFactory::new()->create();
        $user_2 = UserFactory::new()->create();
        $book_user = BookUserFactory::new()->create(attributes: [
            'user_id' => $user_2->id,
            'status' => BookUserStatusEnum::Available,
            'quantity' => 1,
        ]);
        $loan = LoanFactory::new()->create(attributes: [
            'lender_id' => $user_2->id,
            'borrower_id' => $user->id,
            'book_id' => $book_user->book_id,
            'status' => LoanStatusEnum::Requested,
        ]);

        $response = $this->actingAs(user: $user_2)->putJson(
            uri: "/api/v1/loans/{$loan->id}",
            data: [
                'status' => LoanStatusEnum::Approved,
            ]
        );

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'message',
            ]);

        $this->assertDatabaseHas(
            table: 'loans',
            data: [
                'id' => $loan->id,
                'status' => LoanStatusEnum::Approved,
            ]
        );

        $this->assertDatabaseHas(
            table: 'book_user',
            data: [
                'id' => $book_user->id,
                'status' => BookUserStatusEnum::Borrowed,
            ]
        );
    }

    /**
     * @test
     * Test that update loan endpoint returns 200 status code and BookUser status is updated to Borrowed when Loan is approved, the BookUser has a quantity 2 and there is other active loan
     *
     * @return void
     */
    public function test_update_loan_endpoint_returns_200_status_code_and_book_user_status_is_updated_to_borrowed_when_loan_is_approved_the_book_user_has_a_quantity_2_and_there_is_other_active_loan(): void
    {
        $user = UserFactory::new()->create();
        $user_2 = UserFactory::new()->create();
        $user_3 = UserFactory::new()->create();
        $book_user = BookUserFactory::new()->create(attributes: [
            'user_id' => $user_2->id,
            'status' => BookUserStatusEnum::Available,
            'quantity' => 2,
        ]);
        $loan = LoanFactory::new()->create(attributes: [
            'lender_id' => $user_2->id,
            'borrower_id' => $user->id,
            'book_id' => $book_user->book_id,
            'status' => LoanStatusEnum::Requested,
        ]);
        LoanFactory::new()->create(attributes: [
            'lender_id' => $user_2->id,
            'borrower_id' => $user_3->id,
            'book_id' => $book_user->book_id,
            'status' => LoanStatusEnum::Approved,
        ]);

        $response = $this->actingAs(user: $user_2)->putJson(
            uri: "/api/v1/loans/{$loan->id}",
            data: [
                'status' => LoanStatusEnum::Approved,
            ]
        );

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'message',
            ]);

        $this->assertDatabaseHas(
            table: 'loans',
            data: [
                'id' => $loan->id,
                'status' => LoanStatusEnum::Approved,
            ]
        );

        $this->assertDatabaseHas(
            table: 'book_user',
            data: [
                'id' => $book_user->id,
                'status' => BookUserStatusEnum::Borrowed,
            ]
        );
    }

    /**
     * @test
     * Test that update loan endpoint returns 401 status code when user is not logged in
     *
     * @return void
     */
    public function test_update_loan_endpoint_returns_401_status_code_when_user_is_not_logged_in(): void
    {
        $response = $this->putJson(
            uri: '/api/v1/loans/1',
            data: [
                'status' => LoanStatusEnum::Cancelled,
            ]
        );

        $response->assertStatus(status: 401);
    }
}
