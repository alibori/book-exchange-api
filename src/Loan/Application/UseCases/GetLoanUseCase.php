<?php

declare(strict_types=1);

namespace Src\Loan\Application\UseCases;

use App\Models\Loan;
use Illuminate\Database\Eloquent\Collection;
use Src\Loan\Infrastructure\Contracts\GetLoanByCriteriaQueryContract;

final class GetLoanUseCase
{
    public function __construct(private readonly GetLoanByCriteriaQueryContract $get_loan_by_criteria_query)
    {}

    /**
     * Get a Loan by criteria
     *
     * @param array $search_criteria
     * @return Loan|Collection<Loan>|null
     */
    public function handle(array $search_criteria): Loan|Collection|null
    {
        return $this->get_loan_by_criteria_query->handle(criteria: $search_criteria);
    }
}
