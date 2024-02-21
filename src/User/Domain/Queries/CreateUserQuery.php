<?php

declare(strict_types=1);

namespace Src\User\Domain\Queries;

use App\Models\User;
use Src\User\Infrastructure\Contracts\CreateUserQueryContract;

final class CreateUserQuery implements CreateUserQueryContract
{
    public function handle(array $data): User
    {
        /** @var User $user */
        $user = User::query()->create(attributes: $data);

        return $user;
    }
}
