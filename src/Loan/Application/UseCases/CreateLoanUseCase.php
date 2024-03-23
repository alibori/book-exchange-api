<?php

declare(strict_types=1);

namespace Src\Loan\Application\UseCases;

use App\Enums\LoanStatusEnum;
use App\Models\Loan;
use Src\Loan\Infrastructure\Contracts\CreateLoanQueryContract;

final class CreateLoanUseCase
{
    public function __construct(private readonly CreateLoanQueryContract $create_loan_query)
    {}

    /**
     * Create a new Loan
     *
     * @param array{borrower_id: int, lender_id: int, book_id: int, from: string, to: string, status: LoanStatusEnum, quantity: int} $data
     * @return Loan
     */
    public function handle(array $data): Loan
    {
        $loan = $this->create_loan_query->handle(attributes: $data);

        return $loan->load(relations: ['borrower', 'lender', 'book']);
    }
}
