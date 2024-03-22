<?php

declare(strict_types=1);

namespace Src\Book\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Book\Domain\Queries\CreateBookApplicationQuery;
use Src\Book\Domain\Queries\CreateBookUserQuery;
use Src\Book\Domain\Queries\GetBookUserQuery;
use Src\Book\Domain\Queries\ListBooksQuery;
use Src\Book\Domain\Queries\ListCategoriesQuery;
use Src\Book\Infrastructure\Contracts\CreateBookApplicationQueryContract;
use Src\Book\Infrastructure\Contracts\CreateBookUserQueryContract;
use Src\Book\Infrastructure\Contracts\GetBookUserQueryContract;
use Src\Book\Infrastructure\Contracts\ListBooksQueryContract;
use Src\Book\Infrastructure\Contracts\ListCategoriesQueryContract;

final class BookDomainServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, class-string>
     */
    public array $bindings = [
        ListBooksQueryContract::class => ListBooksQuery::class,
        CreateBookApplicationQueryContract::class => CreateBookApplicationQuery::class,
        ListCategoriesQueryContract::class => ListCategoriesQuery::class,
        GetBookUserQueryContract::class => GetBookUserQuery::class,
        CreateBookUserQueryContract::class => CreateBookUserQuery::class,
    ];

    /**
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
