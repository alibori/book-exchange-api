<?php

declare(strict_types=1);

namespace Src\User\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\User\Domain\Queries\CreateUserQuery;
use Src\User\Infrastructure\Contracts\CreateUserQueryContract;

final class UserDomainServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, class-string>
     */
    public array $bindings = [
        CreateUserQueryContract::class => CreateUserQuery::class,
    ];

    /**
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
