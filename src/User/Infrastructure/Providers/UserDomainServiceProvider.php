<?php

declare(strict_types=1);

namespace Src\User\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\User\Domain\Queries\CreateUserQuery;
use Src\User\Domain\Queries\GetUserQuery;
use Src\User\Domain\Queries\ListUsersQuery;
use Src\User\Domain\Queries\UpdateUserQuery;
use Src\User\Infrastructure\Contracts\CreateUserQueryContract;
use Src\User\Infrastructure\Contracts\GetUserQueryContract;
use Src\User\Infrastructure\Contracts\ListUsersQueryContract;
use Src\User\Infrastructure\Contracts\UpdateUserQueryContract;

final class UserDomainServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, class-string>
     */
    public array $bindings = [
        ListUsersQueryContract::class => ListUsersQuery::class,
        CreateUserQueryContract::class => CreateUserQuery::class,
        UpdateUserQueryContract::class => UpdateUserQuery::class,
        GetUserQueryContract::class => GetUserQuery::class,
    ];

    /**
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
