<?php

declare(strict_types=1);

namespace Src\User\Application\UseCases;

use App\Models\User;
use Src\User\Infrastructure\Contracts\UpdateUserQueryContract;

final class UpdateUserUseCase
{
    public function __construct(private readonly UpdateUserQueryContract $update_user_query)
    {}

    public function handle(string|int $user_id, array $data): User
    {
        return $this->update_user_query->handle(user_id: $user_id, data: $data);
    }
}
