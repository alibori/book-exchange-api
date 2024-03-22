<?php

declare(strict_types=1);

namespace Src\Book\Domain\Queries;

use App\Models\BookUser;
use Src\Book\Infrastructure\Contracts\UpdateBookUserQueryContract;

final class UpdateBookUserQuery implements UpdateBookUserQueryContract
{

    /**
     * @inheritDoc
     */
    public function handle(array $attributes, BookUser $book_user): int
    {
        return BookUser::query()
            ->where('id', $book_user->id)
            ->update(values: $attributes);
    }
}
