<?php

declare(strict_types=1);

namespace Src\Loan\Infrastructure\Contracts;

use App\Models\Loan;
use Illuminate\Database\Eloquent\Collection;

interface GetLoanByCriteriaQueryContract
{
    /**
     * Get a Loan by criteria
     *
     * @param array $criteria
     * @return Loan|Collection<Loan>|null
     */
    public function handle(array $criteria): Loan|Collection|null;
}
