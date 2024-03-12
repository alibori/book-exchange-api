<?php

declare(strict_types=1);

namespace Src\User\Infrastructure\Contracts;

use App\Models\User;

interface UpdateUserQueryContract
{
    /**
     * @param string|int $user_id
     * @param array $data
     * @return User
     */
    public function handle(string|int $user_id, array $data): User;
}
