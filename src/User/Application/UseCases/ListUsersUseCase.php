<?php

declare(strict_types=1);

namespace Src\User\Application\UseCases;

use Illuminate\Contracts\Pagination\Paginator;
use Src\User\Infrastructure\Contracts\ListUsersQueryContract;

final class ListUsersUseCase
{
    public function __construct(
        private readonly ListUsersQueryContract $list_users_query
    )
    {}

    /**
     * Get a paginated list of Users
     *
     * @param array|int|null $exclude_user_ids
     * @param array $relationships
     * @param array $count_relations
     * @param array{relation: string, column: string}  $averages
     * @param int|null $per_page
     * @return Paginator
     */
    public function handle(array|int $exclude_user_ids = null, array $relationships = [], array $count_relations = [], array $averages = [], int|null $per_page = 15): Paginator
    {
        return $this->list_users_query->handle(exclude_user_ids: $exclude_user_ids, with: $relationships, with_count: $count_relations, with_avg: $averages, per_page: $per_page ?? 15);
    }
}
