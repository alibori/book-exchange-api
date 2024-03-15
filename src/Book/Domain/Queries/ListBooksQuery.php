<?php

declare(strict_types=1);

namespace Src\Book\Domain\Queries;

use App\Models\Book;
use Illuminate\Contracts\Pagination\Paginator;
use Src\Book\Infrastructure\Contracts\ListBooksQueryContract;

final class ListBooksQuery implements ListBooksQueryContract
{

    /**
     * @inheritDoc
     */
    public function handle(array $with, array $filters, int $per_page): Paginator
    {
        $query = Book::query();

        if (!empty($with)) {
            $query->with($with);
        }

        if (isset($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        if (isset($filters['author'])) {
            $query->whereHas('author', function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['author'] . '%');
            });
        }

        return $query->paginate($per_page);
    }
}
