<?php

declare(strict_types=1);

namespace Src\User\Application\UseCases;

use App\Models\User;
use Src\User\Domain\Queries\CreateUserQuery;

final class CreateUserUseCase
{
    public function handle(array $data): User
    {
        return (new CreateUserQuery)->handle(data: $data);
    }
}
