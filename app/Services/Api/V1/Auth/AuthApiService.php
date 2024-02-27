<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Auth;

use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Hash;
use Src\User\Application\UseCases\CreateUserUseCase;
use Src\User\Application\UseCases\GetUserUseCase;
use Src\User\Domain\Exceptions\UserDomainException;
use Symfony\Component\HttpFoundation\Response;

final class AuthApiService
{
    public function __construct(
        private readonly CreateUserUseCase $create_user_use_case,
        private readonly GetUserUseCase $get_user_use_case
    )
    {}

    /**
     * Register a new User
     *
     * @param  array<string, mixed>  $data
     * @return object
     */
    public function registerUser(array $data): object
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->create_user_use_case->handle(data: $data);

        return (object)[
            'message' => 'User registered successfully',
            'token' => $user->createToken(name: 'auth_token')->plainTextToken,
        ];
    }

    /**
     * Log in a User
     *
     * @param array<string, mixed> $data
     * @return object
     * @throws ApiException
     */
    public function loginUser(array $data): object
    {
        try {
            $user = $this->get_user_use_case->handle(attributes: ['email' => $data['email']]);
        } catch (UserDomainException $e) {
            throw new ApiException(message: trans(key: 'errors.invalid_credentials'), code: Response::HTTP_UNAUTHORIZED);
        }

        if (!Hash::check($data['password'], $user->password)) {
            throw new ApiException(message: trans(key: 'errors.invalid_credentials'), code: Response::HTTP_UNAUTHORIZED);
        }

        return (object)[
            'message' => 'User logged in successfully',
            'token' => $user->createToken(name: 'auth_token')->plainTextToken,
        ];
    }
}
