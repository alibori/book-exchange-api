<?php

declare(strict_types=1);

namespace Src\User\Infrastructure\Contracts;

use Illuminate\Contracts\Pagination\Paginator;

interface ListUsersQueryContract
{
    /**
     * @param array|int|null $exclude_user_ids
     * @param array $with
     * @param array $with_count
     * @param array $with_avg
     * @param int $per_page
     * @return Paginator
     */
    public function handle(array|int $exclude_user_ids = null, array $with = [], array $with_count = [], array $with_avg = [], int $per_page = 15): Paginator;
}
