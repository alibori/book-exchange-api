<?php

declare(strict_types=1);

namespace Src\Book\Infrastructure\Contracts;

use App\Models\BookApplication;

interface CreateBookApplicationQueryContract
{
    /**
     * Create a BookApplication
     *
     * @param array{user_id: int, author_id?: int, author_name?: string, category_id?: int, title: string, description: string} $attributes
     * @return BookApplication
     */
    public function handle(array $attributes): BookApplication;
}
