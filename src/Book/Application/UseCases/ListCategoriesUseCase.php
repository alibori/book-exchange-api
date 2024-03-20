<?php

declare(strict_types=1);

namespace Src\Book\Application\UseCases;

use Illuminate\Contracts\Pagination\Paginator;
use Src\Book\Infrastructure\Contracts\ListCategoriesQueryContract;

final class ListCategoriesUseCase
{
    public function __construct(private readonly ListCategoriesQueryContract $list_categories_query)
    {}

    /**
     * List categories
     *
     * @param int|null $per_page
     * @return Paginator
     */
    public function handle(?int $per_page = null): Paginator
    {
        return $this->list_categories_query->handle(per_page: $per_page ?? 15);
    }
}
