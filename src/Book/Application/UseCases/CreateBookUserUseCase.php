<?php

declare(strict_types=1);

namespace Src\Book\Application\UseCases;

use App\Enums\BookUserStatusEnum;
use App\Models\BookUser;
use Src\Book\Infrastructure\Contracts\CreateBookUserQueryContract;

final class CreateBookUserUseCase
{
    public function __construct(private readonly CreateBookUserQueryContract $create_book_user_query)
    {}

    /**
     * Add a Book in the User's Library
     *
     * @param array{user_id: int, book_id: int, quantity: int} $data
     * @return BookUser
     */
    public function handle(array $data): BookUser
    {
        $data['status'] = BookUserStatusEnum::Available;

        return $this->create_book_user_query->handle(attributes: $data);
    }
}
