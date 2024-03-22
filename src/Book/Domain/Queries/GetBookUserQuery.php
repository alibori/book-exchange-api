<?php

declare(strict_types=1);

namespace Src\Book\Domain\Queries;

use App\Models\BookUser;
use Src\Book\Infrastructure\Contracts\GetBookUserQueryContract;

final class GetBookUserQuery implements GetBookUserQueryContract
{

    /**
     * @inheritDoc
     */
    public function handle(int $user_id, int $book_id): ?BookUser
    {
        /** @var BookUser|null $book_user */
        $book_user = BookUser::query()
            ->where('user_id', $user_id)
            ->where('book_id', $book_id)
            ->first();

        return $book_user;
    }
}
