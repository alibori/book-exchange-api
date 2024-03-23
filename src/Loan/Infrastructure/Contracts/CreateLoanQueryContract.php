<?php

declare(strict_types=1);

namespace Src\Loan\Infrastructure\Contracts;

use App\Enums\LoanStatusEnum;
use App\Models\Loan;

interface CreateLoanQueryContract
{
    /**
     * Create a new Loan
     *
     * @param array{borrower_id: int, lender_id: int, book_id: int, from: string, to: string, status: LoanStatusEnum, quantity: int} $attributes
     * @return Loan
     */
    public function handle(array $attributes): Loan;
}
