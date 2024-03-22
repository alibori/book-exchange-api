<?php

declare(strict_types=1);

namespace Src\Book\Application\UseCases;

use App\Models\BookUser;
use Src\Book\Infrastructure\Contracts\UpdateBookUserQueryContract;

final class UpdateBookUserUseCase
{
    public function __construct(private readonly UpdateBookUserQueryContract $update_book_user_query)
    {}

    /**
     * Update a Book in the User's Library
     *
     * @param array{quantity: int} $data
     * @param BookUser $book_user
     * @return bool
     */
    public function handle(array $data, BookUser $book_user): bool
    {
        return (bool)$this->update_book_user_query->handle(attributes: $data, book_user: $book_user);
    }
}
