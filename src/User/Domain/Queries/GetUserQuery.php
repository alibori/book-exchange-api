<?php

declare(strict_types=1);

namespace Src\User\Domain\Queries;

use App\Models\User;
use Src\User\Infrastructure\Contracts\GetUserQueryContract;

final class GetUserQuery implements GetUserQueryContract
{
    public function handle(array $data, array $with = []): ?User
    {
        $query = User::query();

        foreach ($data as $key => $value) {
            $query->where($key, $value);
        }

        if (!empty($with)) {
            $query->with($with);
        }

        /** @var User|null $user */
        $user = $query->first();

        return $user;
    }
}
