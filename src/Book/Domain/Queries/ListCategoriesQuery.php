<?php

declare(strict_types=1);

namespace Src\Book\Domain\Queries;

use App\Models\Category;
use Illuminate\Contracts\Pagination\Paginator;
use Src\Book\Infrastructure\Contracts\ListCategoriesQueryContract;

final class ListCategoriesQuery implements ListCategoriesQueryContract
{

    /**
     * @inheritDoc
     */
    public function handle(int $per_page): Paginator
    {
        return Category::query()->paginate($per_page);
    }
}
