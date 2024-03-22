<?php

declare(strict_types=1);

namespace Src\Book\Domain\Queries;

use App\Models\BookUser;
use Src\Book\Infrastructure\Contracts\CreateBookUserQueryContract;

final class CreateBookUserQuery implements CreateBookUserQueryContract
{

    /**
     * @inheritDoc
     */
    public function handle(array $attributes): BookUser
    {
        /** @var BookUser $book_user */
        $book_user = BookUser::query()->create(attributes: $attributes);

        return $book_user;
    }
}
