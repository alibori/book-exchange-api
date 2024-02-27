<?php

declare(strict_types=1);

namespace Src\User\Infrastructure\Contracts;

use App\Models\User;

interface GetUserQueryContract
{
    /**
     * Query to get User
     *
     * @param array $data
     * @param array $with
     * @return User|null
     */
    public function handle(array $data, array $with = []): ?User;
}
