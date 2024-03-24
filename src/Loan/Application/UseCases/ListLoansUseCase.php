<?php

declare(strict_types=1);

namespace Src\Loan\Application\UseCases;

use App\Enums\LoanStatusEnum;
use Illuminate\Contracts\Pagination\Paginator;
use Src\Loan\Infrastructure\Contracts\ListLoansQueryContract;

final class ListLoansUseCase
{
    public function __construct(private readonly ListLoansQueryContract $list_loans_query)
    {}

    /**
     * List a paginated list of Loans where the current user is the borrower or lender
     *
     * @param int $user_id
     * @param array{results?: int, page?: int, status?: LoanStatusEnum, as?: string} $filters
     * @return Paginator
     */
    public function handle(int $user_id, array $filters): Paginator
    {
        $with = ['book', 'borrower', 'lender'];
        $per_page = isset($filters['results']) ? (int)$filters['results'] : 15;
        $query_filters = [];

        if (isset($filters['status'])) {
            $query_filters['status'] = $filters['status'];
        }

        if (isset($filters['as'])) {
            $query_filters['as'] = $filters['as'];
        }

        return $this->list_loans_query->handle(
            user_id: $user_id,
            with: $with,
            filters: $query_filters,
            per_page: $per_page
        );
    }
}
