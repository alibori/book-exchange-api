<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Book;

use Illuminate\Contracts\Pagination\Paginator;
use Src\Book\Application\UseCases\ListCategoriesUseCase;

final class CategoryApiService
{
    public function __construct(private readonly ListCategoriesUseCase $list_categories_use_case)
    {}

    /**
     * List categories
     *
     * @param array{page?: int, results?: int} $data
     * @return Paginator
     */
    public function listCategories(array $data): Paginator
    {
        $per_page = null;

        if (isset($data['results']) && is_numeric($data['results'])) {
            $per_page = (int)$data['results'];
        }

        return $this->list_categories_use_case->handle(per_page: $per_page); // TODO: return books_count relationship loaded
    }
}
