<?php

namespace Tests\Feature\Api\V1\Auth;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutUserEndpointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Test that logout user endpoint returns 200 status code and user is logged out
     *
     * @return void
     */
    public function test_logout_user_endpoint_returns_200_status_code_and_user_is_logged_out(): void
    {
        $user = UserFactory::new()->create();

        $response = $this->actingAs(user: $user)
            ->deleteJson(
                uri: '/api/v1/logout'
            );

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'message'
            ]);
    }

    /**
     * @test
     * Test that logout user endpoint returns 401 status code when user is not logged in
     *
     * @return void
     */
    public function test_logout_user_endpoint_returns_401_status_code_when_user_is_not_logged_in(): void
    {
        $response = $this->deleteJson(
            uri: '/api/v1/logout'
        );

        $response->assertStatus(status: 401)
            ->assertJsonStructure([
                'message'
            ]);
    }
}
