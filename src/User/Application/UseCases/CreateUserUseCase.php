<?php

declare(strict_types=1);

namespace Src\User\Application\UseCases;

use App\Models\User;
use Src\User\Infrastructure\Contracts\CreateUserQueryContract;

final class CreateUserUseCase
{
    public function __construct(private readonly CreateUserQueryContract $create_user_query)
    {}

    public function handle(array $data): User
    {
        return $this->create_user_query->handle(data: $data);
    }
}
