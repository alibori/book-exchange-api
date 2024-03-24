<?php

declare(strict_types=1);

namespace Src\Loan\Domain\Queries;

use App\Models\Loan;
use Illuminate\Contracts\Pagination\Paginator;
use Src\Loan\Infrastructure\Contracts\ListLoansQueryContract;

final class ListLoansQuery implements ListLoansQueryContract
{

    /**
     * @inheritDoc
     */
    public function handle(int $user_id, array $with = [], array $filters = [], int $per_page = 15): Paginator
    {
        $query = Loan::query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['as'])) {
            if ($filters['as'] === 'borrower') {
                $query->where('borrower_id', $user_id);
            } elseif ($filters['as'] === 'lender') {
                $query->where('lender_id', $user_id);
            }
        } else {
            $query->where('borrower_id', $user_id)
                ->orWhere('lender_id', $user_id);
        }

        if (!empty($with)) {
            $query->with($with);
        }

        return $query->paginate($per_page);
    }
}
