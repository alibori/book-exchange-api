<?php

declare(strict_types=1);

namespace Src\Loan\Application\UseCases;

use App\Models\Loan;
use Src\Loan\Infrastructure\Contracts\UpdateLoanStatusQueryContract;

final class UpdateLoanStatusUseCase
{
    public function __construct(
        private readonly UpdateLoanStatusQueryContract $update_loan_status_query
    )
    {}

    public function handle(int $loan_id, string $status): Loan
    {
        return $this->update_loan_status_query->handle(loan_id: $loan_id, status: $status);
    }
}
