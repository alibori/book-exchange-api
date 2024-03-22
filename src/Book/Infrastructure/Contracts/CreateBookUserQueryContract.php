<?php

declare(strict_types=1);

namespace Src\Book\Infrastructure\Contracts;

use App\Enums\BookUserStatusEnum;
use App\Models\BookUser;

interface CreateBookUserQueryContract
{
    /**
     * Add a Book to the User's Library
     *
     * @param array{user_id: int, book_id: int, quantity: int, status: BookUserStatusEnum} $attributes
     * @return BookUser
     */
    public function handle(array $attributes): BookUser;
}
