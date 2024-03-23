<?php

declare(strict_types=1);

namespace Src\Loan\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Loan\Domain\Queries\CreateLoanQuery;
use Src\Loan\Infrastructure\Contracts\CreateLoanQueryContract;

final class LoanDomainServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, class-string>
     */
    public array $bindings = [
         CreateLoanQueryContract::class => CreateLoanQuery::class,
    ];

    /**
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
