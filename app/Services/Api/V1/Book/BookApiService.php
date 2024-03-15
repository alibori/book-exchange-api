<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Book;

use Illuminate\Contracts\Pagination\Paginator;
use Src\Book\Application\UseCases\ListBooksUseCase;

final class BookApiService
{
    public function __construct(
        private readonly ListBooksUseCase $list_books_use_case
    )
    {}

    /**
     * List books
     *
     * @param array $data
     * @return Paginator
     */
    public function listBooks(array $data): Paginator
    {
        $filters = [];
        $per_page = null;

        if (isset($data['results']) && is_numeric($data['results'])) {
            $per_page = (int)$data['results'];
        }

        if (isset($data['title'])) {
            $filters['title'] = $data['title'];
        }

        if (isset($data['author'])) {
            $filters['author'] = $data['author'];
        }

        return $this->list_books_use_case->handle(relationships: ['author', 'category'], filters: $filters, per_page: $per_page);
    }
}
