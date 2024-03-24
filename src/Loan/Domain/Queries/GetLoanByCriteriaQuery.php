<?php

declare(strict_types=1);

namespace Src\Loan\Domain\Queries;

use App\Models\Loan;
use Illuminate\Database\Eloquent\Collection;
use Src\Loan\Infrastructure\Contracts\GetLoanByCriteriaQueryContract;

final class GetLoanByCriteriaQuery implements GetLoanByCriteriaQueryContract
{

    /**
     * @inheritDoc
     */
    public function handle(array $criteria): Loan|Collection|null
    {
        $query = Loan::query();

        foreach ($criteria as $key => $value) {
            $query->where($key, $value);
        }

        /** @var Loan|Collection<Loan>|null $loan */
        $loan = $query->get();

        return $loan;
    }
}
