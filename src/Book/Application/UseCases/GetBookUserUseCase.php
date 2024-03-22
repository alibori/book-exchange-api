<?php

declare(strict_types=1);

namespace Src\Book\Application\UseCases;

use App\Models\BookUser;
use Src\Book\Infrastructure\Contracts\GetBookUserQueryContract;

final class GetBookUserUseCase
{
    public function __construct(private readonly GetBookUserQueryContract $get_book_user_query)
    {}

    public function handle(int $user_id, int $book_id): ?BookUser
    {
        return $this->get_book_user_query->handle(user_id: $user_id, book_id: $book_id);
    }
}
