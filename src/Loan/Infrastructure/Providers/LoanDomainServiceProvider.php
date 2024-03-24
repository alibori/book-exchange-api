<?php

declare(strict_types=1);

namespace Src\Loan\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Loan\Domain\Queries\CreateLoanQuery;
use Src\Loan\Domain\Queries\GetLoanByCriteriaQuery;
use Src\Loan\Domain\Queries\ListLoansQuery;
use Src\Loan\Domain\Queries\UpdateLoanStatusQuery;
use Src\Loan\Infrastructure\Contracts\CreateLoanQueryContract;
use Src\Loan\Infrastructure\Contracts\GetLoanByCriteriaQueryContract;
use Src\Loan\Infrastructure\Contracts\ListLoansQueryContract;
use Src\Loan\Infrastructure\Contracts\UpdateLoanStatusQueryContract;

final class LoanDomainServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, class-string>
     */
    public array $bindings = [
         CreateLoanQueryContract::class => CreateLoanQuery::class,
        GetLoanByCriteriaQueryContract::class => GetLoanByCriteriaQuery::class,
        UpdateLoanStatusQueryContract::class => UpdateLoanStatusQuery::class,
        ListLoansQueryContract::class => ListLoansQuery::class,
    ];

    /**
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
