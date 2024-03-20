<?php

declare(strict_types=1);

namespace Src\Book\Domain\Queries;

use App\Models\BookApplication;
use Src\Book\Infrastructure\Contracts\CreateBookApplicationQueryContract;

final class CreateBookApplicationQuery implements CreateBookApplicationQueryContract
{

    /**
     * @inheritDoc
     */
    public function handle(array $attributes): BookApplication
    {
        /** @var BookApplication $book_application */
        $book_application = BookApplication::query()->create(attributes: $attributes);

        return $book_application;
    }
}
