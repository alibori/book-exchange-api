<?php

declare(strict_types=1);

namespace Src\Book\Application\UseCases;

use Illuminate\Contracts\Pagination\Paginator;
use Src\Book\Infrastructure\Contracts\ListBooksQueryContract;

final class ListBooksUseCase
{
public function __construct(
        private readonly ListBooksQueryContract $list_books_query
    )
    {}

    /**
     * @param array $relationships
     * @param array $filters
     * @param int|null $per_page
     * @return Paginator
     */
    public function handle(array $relationships = [], array $filters = [], int $per_page = null): Paginator
    {
        return $this->list_books_query->handle(with: $relationships, filters: $filters, per_page: $per_page ?? 15);
    }
}
