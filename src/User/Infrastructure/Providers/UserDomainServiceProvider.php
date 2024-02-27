<?php

declare(strict_types=1);

namespace Src\User\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\User\Domain\Queries\CreateUserQuery;
use Src\User\Domain\Queries\GetUserQuery;
use Src\User\Infrastructure\Contracts\CreateUserQueryContract;
use Src\User\Infrastructure\Contracts\GetUserQueryContract;

final class UserDomainServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, class-string>
     */
    public array $bindings = [
        CreateUserQueryContract::class => CreateUserQuery::class,
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
