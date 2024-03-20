<?php

declare(strict_types=1);

namespace Src\Book\Application\UseCases;

use App\Enums\BookApplicationStatusEnum;
use App\Models\BookApplication;
use Src\Book\Infrastructure\Contracts\CreateBookApplicationQueryContract;

final class CreateBookApplicationUseCase
{
    public function __construct(private readonly CreateBookApplicationQueryContract $create_book_application_query)
    {}

    /**
     * Create a BookApplication
     *
     * @param array{user_id: int, author_id?: int, author_name?: string, category_id?: int, title: string, description: string} $data
     * @return BookApplication
     */
    public function handle(array $data): BookApplication
    {
        $data['status'] = BookApplicationStatusEnum::Pending;

        $book_application = $this->create_book_application_query->handle(attributes: $data);

        return $book_application->load(relations: ['author', 'category']);
    }
}
