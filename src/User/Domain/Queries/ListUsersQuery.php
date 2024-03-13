<?php

declare(strict_types=1);

namespace Src\User\Domain\Queries;

use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Src\User\Infrastructure\Contracts\ListUsersQueryContract;

final class ListUsersQuery implements ListUsersQueryContract
{

    /**
     * @inheritDoc
     */
    public function handle(array|int $exclude_user_ids = null, array $with = [], array $with_count = [], array $with_avg = [], int $per_page = 15): Paginator
    {
        $builder = User::query();

        if ($exclude_user_ids) {
            if (is_array($exclude_user_ids)) {
                $builder->whereNotIn('id', $exclude_user_ids);
            } else {
                $builder->where('id', '!=', $exclude_user_ids);
            }
        }

        if (!empty($with)) {
            $builder->with($with);
        }

        if (!empty($with_count)) {
            $builder->withCount($with_count);
        }

        if (!empty($with_avg)) {
            $builder->withAvg($with_avg['relation'], $with_avg['column']);
        }

        return $builder->simplePaginate(perPage: $per_page);
    }
}
