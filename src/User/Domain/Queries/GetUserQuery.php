<?php

declare(strict_types=1);

namespace Src\User\Domain\Queries;

use App\Models\User;
use Src\User\Infrastructure\Contracts\GetUserQueryContract;

final class GetUserQuery implements GetUserQueryContract
{
    public function handle(array $data, array $with = [], array $with_count = [], array $with_avg = []): ?User
    {
        $query = User::query();

        foreach ($data as $key => $value) {
            $query->where($key, $value);
        }

        if (!empty($with)) {
            $query->with($with);
        }

        if (!empty($with_count)) {
            $query->withCount($with_count);
        }

        if (!empty($with_avg)) {
            $query->withAvg($with_avg['relation'], $with_avg['column']);
        }

        /** @var User|null $user */
        $user = $query->first();

        return $user;
    }
}
