<?php

declare(strict_types=1);

namespace Src\Book\Infrastructure\Contracts;

use App\Models\BookUser;

interface GetBookUserQueryContract
{
    /**
     * Get a Book from the User's Library
     *
     * @param int $user_id
     * @param int $book_id
     * @return BookUser|null
     */
    public function handle(int $user_id, int $book_id): ?BookUser;
}
