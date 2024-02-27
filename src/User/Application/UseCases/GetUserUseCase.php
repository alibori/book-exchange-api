<?php

declare(strict_types=1);

namespace Src\User\Application\UseCases;

use App\Models\User;
use Src\User\Domain\Exceptions\UserDomainException;
use Src\User\Domain\Queries\GetUserQuery;
use Symfony\Component\HttpFoundation\Response;

final class GetUserUseCase
{
    /**
     * Get a User
     *
     * @param  array  $attributes
     * @param  array  $relations
     * @return User
     * @throws UserDomainException
     */
    public function handle(array $attributes, array $relations = []): User
    {
        /** @var User|null $user */
        $user = (new GetUserQuery)->handle(data: $attributes, with: $relations);

        if (!$user) {
            throw new UserDomainException(message: trans(key: 'errors.user.not_found'), code: Response::HTTP_NOT_FOUND);
        }

        return $user;
    }
}
