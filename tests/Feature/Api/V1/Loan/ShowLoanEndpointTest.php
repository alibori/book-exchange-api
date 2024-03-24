<?php

namespace Tests\Feature\Api\V1\Loan;

use Database\Factories\LoanFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowLoanEndpointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Test that show loan endpoint returns 200 status code and a Loan Resource when process is successful
     *
     * @return void
     */
    public function test_show_loan_endpoint_returns_200_status_code_and_a_loan_resource_when_process_is_successful(): void
    {
        $user = UserFactory::new()->create();
        $loan = LoanFactory::new()->create(attributes: ['borrower_id' => $user->id]);

        $response = $this->actingAs($user)->getJson(uri: "/api/v1/loans/{$loan->id}");

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'id',
                'lender',
                'borrower',
                'book',
                'from',
                'to',
                'status',
            ]);
    }

    /**
     * @test
     * Test that show loan endpoint returns 404 status code and an error message when Loan does not exist
     *
     * @return void
     */
    public function test_show_loan_endpoint_returns_404_status_code_and_an_error_message_when_loan_does_not_exist(): void
    {
        $user = UserFactory::new()->create();

        $response = $this->actingAs($user)->getJson(uri: '/api/v1/loans/1');

        $response->assertStatus(status: 404);
    }

    /**
     * @test
     * Test that show loan endpoint returns 403 status code and an error message when Loan does not belong to the current user
     *
     * @return void
     */
    public function test_show_loan_endpoint_returns_403_status_code_and_an_error_message_when_loan_does_not_belong_to_the_current_user(): void
    {
        $user = UserFactory::new()->create();
        $user_2 = UserFactory::new()->create();
        $user_3 = UserFactory::new()->create();
        $loan = LoanFactory::new()->create(attributes: [
            'borrower_id' => $user_2->id,
            'lender_id' => $user_3->id,
        ]);

        $response = $this->actingAs($user)->getJson(uri: "/api/v1/loans/{$loan->id}");

        $response->assertStatus(status: 403);
    }

    /**
     * @test
     * Test that show loan endpoint returns 401 status code and an error message when user is not authenticated
     *
     * @return void
     */
    public function test_show_loan_endpoint_returns_401_status_code_and_an_error_message_when_user_is_not_authenticated(): void
    {
        $response = $this->getJson(uri: '/api/v1/loans/1');

        $response->assertStatus(status: 401);
    }
}
