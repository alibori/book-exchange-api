<?php

declare(strict_types=1);

namespace Src\Loan\Infrastructure\Contracts;

use App\Models\Loan;

interface UpdateLoanStatusQueryContract
{
    /**
     * Update the status of a Loan
     *
     * @param int $loan_id
     * @param string $status
     * @return Loan
     */
    public function handle(int $loan_id, string $status): Loan;
}
