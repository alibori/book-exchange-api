<?php

declare(strict_types=1);

namespace Src\Book\Infrastructure\Contracts;

use Illuminate\Contracts\Pagination\Paginator;

interface ListBooksQueryContract
{
    /**
     * List books
     *
     * @param array $with
     * @param array $filters
     * @param int $per_page
     * @return Paginator
     */
    public function handle(array $with, array $filters, int $per_page): Paginator;
}
