<?php

namespace Tests\Feature\Api\V1\User;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowUserEndpointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Test that show user endpoint returns 200 status code and user information when user is found
     *
     * @return void
     */
    public function test_show_user_endpoint_returns_200_status_code_and_user_information_when_user_is_found(): void
    {
        $user = UserFactory::new()->create();

        $response = $this->actingAs(user: $user)
            ->getJson(
                uri: '/api/v1/users/' . $user->id
            );

        $response->assertStatus(status: 200)
            ->assertJsonStructure([
                'id',
                'name',
                'email',
            ]);
    }

    /**
     * @test
     * Test that show user endpoint returns 401 status code when user is not logged in
     *
     * @return void
     */
    public function test_show_user_endpoint_returns_401_status_code_when_user_is_not_logged_in(): void
    {
        $response = $this->getJson(
            uri: '/api/v1/users/1'
        );

        $response->assertStatus(status: 401)
            ->assertJsonStructure([
                'message'
            ]);
    }

    /**
     * @test
     * Test that show user endpoint returns 404 status code when user is not found
     *
     * @return void
     */
    public function test_show_user_endpoint_returns_404_status_code_when_user_is_not_found(): void
    {
        $user = UserFactory::new()->create();
        $total_users = User::all();

        $response = $this->actingAs(user: $user)
            ->getJson(
                uri: '/api/v1/users/'.($total_users->count() + 1)
            );

        $response->assertStatus(status: 404)
            ->assertJsonStructure([
                'error'
            ]);
    }
}
