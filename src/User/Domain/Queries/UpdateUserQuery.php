<?php

declare(strict_types=1);

namespace Src\User\Domain\Queries;

use App\Models\User;
use Src\User\Infrastructure\Contracts\UpdateUserQueryContract;

final class UpdateUserQuery implements UpdateUserQueryContract
{

    /**
     * @inheritDoc
     */
    public function handle(string|int $user_id, array $data): User
    {
        /** @var User $user */
        $user = User::query()->updateOrCreate(
            attributes: ['id' => $user_id],
            values: $data
        );

        return $user;
    }
}
