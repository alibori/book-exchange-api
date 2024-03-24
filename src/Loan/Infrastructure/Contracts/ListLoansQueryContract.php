<?php

declare(strict_types=1);

namespace Src\Loan\Infrastructure\Contracts;

use App\Enums\LoanStatusEnum;
use Illuminate\Contracts\Pagination\Paginator;

interface ListLoansQueryContract
{
    /**
     * List loans
     *
     * @param int $user_id
     * @param array $with
     * @param array{status?: LoanStatusEnum, as?: string} $filters
     * @param int $per_page
     * @return Paginator
     */
    public function handle(int $user_id, array $with = [], array $filters = [], int $per_page = 15): Paginator;
}
