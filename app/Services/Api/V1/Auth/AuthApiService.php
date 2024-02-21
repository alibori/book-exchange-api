<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Auth;

use Src\User\Application\UseCases\CreateUserUseCase;

final class AuthApiService
{
    public function __construct(private readonly CreateUserUseCase $create_user_use_case)
    {}

    /**
     * Register a new user
     *
     * @param  array<string, mixed>  $data
     * @return object
     */
    public function registerUser(array $data): object
    {
        $user = $this->create_user_use_case->handle(data: $data);

        return (object)[
            'message' => 'User registered successfully',
            'token' => $user->createToken(name: 'auth_token')->plainTextToken,
        ];
    }
}
