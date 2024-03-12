<?php

declare(strict_types=1);

namespace App\Services\Api\V1\User;

use App\Exceptions\ApiException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Src\User\Application\UseCases\GetUserUseCase;
use Src\User\Application\UseCases\UpdateUserUseCase;
use Src\User\Domain\Exceptions\UserDomainException;
use Symfony\Component\HttpFoundation\Response;

final class UserApiService
{
    public function __construct(
        private readonly GetUserUseCase $get_user_use_case,
        private readonly UpdateUserUseCase $update_user_use_case
    )
    {}

    /**
     * Get User by id
     *
     * @param string $id
     * @return User
     * @throws ApiException
     */
    public function getUser(string $id): User
    {
        try {
            return $this->get_user_use_case->handle(attributes: ['id' => $id], count_relations: ['books', 'loans'], averages: ['relation' => 'ratings', 'column' => 'rating']);
        } catch (UserDomainException $e) {
            throw new ApiException(message: $e->getMessage(), code: $e->getCode());
        }
    }

    /**
     * Update User by id
     *
     * @param string $id
     * @param array<string, mixed> $attributes
     * @return User
     * @throws ApiException
     */
    public function updateUser(string $id, array $attributes): User
    {
        $current_user_id = Auth::id();

        if ($current_user_id !== (int)$id) {
            throw new ApiException(message: trans(key: 'errors.forbidden'), code: Response::HTTP_FORBIDDEN);
        }

        return $this->update_user_use_case->handle(user_id: $id, data: $attributes);
    }
}
