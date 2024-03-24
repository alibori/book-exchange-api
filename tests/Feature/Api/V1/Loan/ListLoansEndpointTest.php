<?php

namespace Tests\Feature\Api\V1\Loan;

use App\Enums\LoanStatusEnum;
use Database\Factories\LoanFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListLoansEndpointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Test that list loans endpoint returns 200 status code and a paginated list of Loan Resources when process is successful
     *
     * @return void
     */
    public function test_list_loans_endpoint_returns_200_status_code_and_a_paginated_list_of_loan_resources_when_process_is_successful(): void
    {
        $user = UserFactory::new()->create();
        LoanFactory::new()->count(5)->create(attributes:['borrower_id' => $user->id]);

        $response = $this->actingAs($user)->getJson(uri: '/api/v1/loans');

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'lender',
                        'borrower',
                        'book',
                        'from',
                        'to',
                        'status',
                    ],
                ],
                'pagination'
            ]);

        $this->assertCount(5, $response->json(key: 'data'));
    }

    /**
     * @test
     * Test that list loans endpoint returns 200 status code and a paginated list of Loan Resources filtered by status when process is successful
     *
     * @return void
     */
    public function test_list_loans_endpoint_returns_200_status_code_and_a_paginated_list_of_loan_resources_filtered_by_status_when_process_is_successful(): void
    {
        $user = UserFactory::new()->create();
        LoanFactory::new()->count(2)->create(attributes:['borrower_id' => $user->id, 'status' => LoanStatusEnum::Requested]);
        LoanFactory::new()->count(2)->create(attributes:['borrower_id' => $user->id, 'status' => LoanStatusEnum::Approved]);

        $response = $this->actingAs($user)->getJson(uri: '/api/v1/loans?status=requested');

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'lender',
                        'borrower',
                        'book',
                        'from',
                        'to',
                        'status',
                    ],
                ],
                'pagination'
            ]);

        $this->assertCount(2, $response->json(key: 'data'));
    }

    /**
     * @test
     * Test that list loans endpoint returns 200 status code and a paginated list of Loan Resources filtered by borrower when process is successful
     *
     * @return void
     */
    public function test_list_loans_endpoint_returns_200_status_code_and_a_paginated_list_of_loan_resources_filtered_by_borrower_when_process_is_successful(): void
    {
        $user = UserFactory::new()->create();
        LoanFactory::new()->count(2)->create(attributes:['borrower_id' => $user->id]);
        LoanFactory::new()->count(2)->create(attributes:['lender_id' => $user->id]);

        $response = $this->actingAs($user)->getJson(uri: '/api/v1/loans?as=borrower');

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'lender',
                        'borrower',
                        'book',
                        'from',
                        'to',
                        'status',
                    ],
                ],
                'pagination'
            ]);

        $this->assertCount(2, $response->json(key: 'data'));
    }

    /**
     * @test
     * Test that list loans endpoint returns 200 status code and a paginated list of Loan Resources filtered by lender when process is successful
     *
     * @return void
     */
    public function test_list_loans_endpoint_returns_200_status_code_and_a_paginated_list_of_loan_resources_filtered_by_lender_when_process_is_successful(): void
    {
        $user = UserFactory::new()->create();
        LoanFactory::new()->count(2)->create(attributes:['borrower_id' => $user->id]);
        LoanFactory::new()->count(2)->create(attributes:['lender_id' => $user->id]);

        $response = $this->actingAs($user)->getJson(uri: '/api/v1/loans?as=lender');

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'lender',
                        'borrower',
                        'book',
                        'from',
                        'to',
                        'status',
                    ],
                ],
                'pagination'
            ]);

        $this->assertCount(2, $response->json(key: 'data'));
    }

    /**
     * @test
     * Test that list loans endpoint returns 200 status code and a paginated list of Loan Resources filtered by page when process is successful
     *
     * @return void
     */
    public function test_list_loans_endpoint_returns_200_status_code_and_a_paginated_list_of_loan_resources_filtered_by_page_when_process_is_successful(): void
    {
        $user = UserFactory::new()->create();
        LoanFactory::new()->count(5)->create(attributes:['borrower_id' => $user->id]);

        $response = $this->actingAs($user)->getJson(uri: '/api/v1/loans?page=2&results=2');

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'lender',
                        'borrower',
                        'book',
                        'from',
                        'to',
                        'status',
                    ],
                ],
                'pagination'
            ])
            ->assertJson([
                'pagination' => [
                    'current_page' => 2,
                ]
            ]);

        $this->assertCount(2, $response->json(key: 'data'));
    }

    /**
     * @test
     * Test that list loans endpoint returns 401 status code when user is not logged in
     *
     * @return void
     */
    public function test_list_loans_endpoint_returns_401_status_code_when_user_is_not_logged_in(): void
    {
        $response = $this->getJson(uri: '/api/v1/loans');

        $response->assertStatus(status: 401);
    }
}
