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
     * @param array $with_count
     * @param array $with_avg
     * @return User|null
     */
    public function handle(array $data, array $with = [], array $with_count = [], array $with_avg = []): ?User;
}
