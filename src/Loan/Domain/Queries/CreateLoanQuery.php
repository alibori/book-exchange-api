<?php

declare(strict_types=1);

namespace Src\Loan\Domain\Queries;

use App\Models\Loan;
use Src\Loan\Infrastructure\Contracts\CreateLoanQueryContract;

final class CreateLoanQuery implements CreateLoanQueryContract
{

    /**
     * @inheritDoc
     */
    public function handle(array $attributes): Loan
    {
        /** @var Loan $loan */
        $loan = Loan::query()->create(attributes: $attributes);

        return $loan;
    }
}
