<?php

declare(strict_types=1);

namespace Src\Book\Infrastructure\Contracts;

use Illuminate\Contracts\Pagination\Paginator;

interface ListCategoriesQueryContract
{
    /**
     * List categories
     *
     * @param int $per_page
     * @return Paginator
     */
    public function handle(int $per_page): Paginator;
}
