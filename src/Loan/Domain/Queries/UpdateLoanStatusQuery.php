<?php

declare(strict_types=1);

namespace Src\Loan\Domain\Queries;

use App\Models\Loan;
use Src\Loan\Infrastructure\Contracts\UpdateLoanStatusQueryContract;

final class UpdateLoanStatusQuery implements UpdateLoanStatusQueryContract
{

    /**
     * @inheritDoc
     */
    public function handle(int $loan_id, string $status): Loan
    {
        /** @var Loan $loan */
        $loan = Loan::query()->updateOrCreate(
            attributes: ['id' => $loan_id],
            values: ['status' => $status]
        );

        return $loan;
    }
}
