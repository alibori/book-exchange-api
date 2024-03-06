<?php

declare(strict_types=1);

namespace App\Services\Api\V1\User;

use App\Exceptions\ApiException;
use App\Models\User;
use Src\User\Application\UseCases\GetUserUseCase;
use Src\User\Domain\Exceptions\UserDomainException;

final class UserApiService
{
    public function __construct(private readonly GetUserUseCase $get_user_use_case)
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
}
