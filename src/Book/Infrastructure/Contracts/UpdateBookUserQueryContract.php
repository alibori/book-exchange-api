<?php

declare(strict_types=1);

namespace Src\Book\Infrastructure\Contracts;

use App\Enums\BookUserStatusEnum;
use App\Models\BookUser;

interface UpdateBookUserQueryContract
{
    /**
     * Update a BookUser record.
     *
     * @param array{quantity: int, status: BookUserStatusEnum} $attributes
     * @param BookUser $book_user
     * @return int
     */
    public function handle(array $attributes, BookUser $book_user): int;
}
