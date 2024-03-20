<?php

declare(strict_types=1);

namespace Src\Book\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Book\Domain\Queries\CreateBookApplicationQuery;
use Src\Book\Domain\Queries\ListBooksQuery;
use Src\Book\Infrastructure\Contracts\CreateBookApplicationQueryContract;
use Src\Book\Infrastructure\Contracts\ListBooksQueryContract;

final class BookDomainServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, class-string>
     */
    public array $bindings = [
        ListBooksQueryContract::class => ListBooksQuery::class,
        CreateBookApplicationQueryContract::class => CreateBookApplicationQuery::class,
    ];

    /**
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
