<?php

declare(strict_types=1);

namespace Src\Loan\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;

final class LoanDomainServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, class-string>
     */
    public array $bindings = [
         //
    ];

    /**
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
