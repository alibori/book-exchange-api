<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Loan;

use App\Enums\BookUserStatusEnum;
use App\Enums\LoanStatusEnum;
use App\Exceptions\ApiException;
use App\Models\Loan;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Src\Book\Application\UseCases\GetBookUserUseCase;
use Src\Book\Application\UseCases\UpdateBookUserUseCase;
use Src\Loan\Application\UseCases\CreateLoanUseCase;
use Src\Loan\Application\UseCases\GetLoanUseCase;
use Src\Loan\Application\UseCases\ListLoansUseCase;
use Src\Loan\Application\UseCases\UpdateLoanStatusUseCase;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class LoanApiService
{
    public function __construct(
        private readonly GetBookUserUseCase $get_book_user_use_case,
        private readonly UpdateBookUserUseCase $update_book_user_use_case,
        private readonly CreateLoanUseCase $create_loan_use_case,
        private readonly GetLoanUseCase $get_loan_use_case,
        private readonly UpdateLoanStatusUseCase $update_loan_status_use_case,
        private readonly ListLoansUseCase $list_loans_use_case
    )
    {}

    /**
     * List a paginated list of Loans where the current user is the borrower or lender
     *
     * @param array{results?: int, page?: int, status?: LoanStatusEnum, as?: string} $data
     * @return Paginator
     */
    public function list(array $data): Paginator
    {
        $current_user_id = Auth::id();

        return $this->list_loans_use_case->handle(
            user_id: $current_user_id,
            filters: $data
        );
    }

    /**
     * Request a Loan
     *
     * @param array $data
     * @return Loan
     * @throws ApiException
     */
    public function requestLoan(array $data): Loan
    {
        $current_user_id = Auth::id();

        $book_user = $this->get_book_user_use_case->handle(
            user_id: (int)$data['lender_id'],
            book_id: (int)$data['book_id']
        );

        if (!$book_user) {
            throw new ApiException(
                message: trans(key: 'errors.book.not_in_library'),
                code: Response::HTTP_NOT_FOUND
            );
        } elseif ($book_user->status === (BookUserStatusEnum::Borrowed)->value) {
            throw new ApiException(
                message: trans(key: 'errors.book.is_borrowed'),
                code: Response::HTTP_BAD_REQUEST
            );
        }

        $data['borrower_id'] = $current_user_id;
        $data['status'] = LoanStatusEnum::Requested;
        $data['quantity'] = 1;

        return $this->create_loan_use_case->handle(data: $data);
    }

    /**
     * Update a Loan's status
     *
     * @param array $data
     * @param string $loan_id
     * @return Loan
     * @throws ApiException
     * @throws Throwable
     */
    public function updateLoanStatus(array $data, string $loan_id): Loan
    {
        $current_user_id = Auth::id();

        $loan = $this->get_loan_use_case->handle(search_criteria: ['id' => $loan_id]);

        if (!$loan || $loan->count() === 0){
            throw new ApiException(
                message: trans(key: 'errors.loan.not_found'),
                code: Response::HTTP_NOT_FOUND
            );
        }

        $loan = $loan->first();

        if ($loan->borrower_id !== $current_user_id && $loan->lender_id !== $current_user_id) {
            throw new ApiException(
                message: trans(key: 'errors.forbidden'),
                code: Response::HTTP_FORBIDDEN
            );
        }

        $book_user = $this->get_book_user_use_case->handle(
            user_id: $loan->lender_id,
            book_id: $loan->book_id
        );

        if (!$book_user) {
            throw new ApiException(
                message: trans(key: 'errors.book.not_in_library'),
                code: Response::HTTP_NOT_FOUND
            );
        }

        if (($loan->borrower_id === $current_user_id && $loan->status !== LoanStatusEnum::Requested) || ($loan->borrower_id === $current_user_id && $loan->status === LoanStatusEnum::Requested && $data['status'] !== (LoanStatusEnum::Cancelled)->value)) {
            throw new ApiException(
                message: trans(key: 'errors.forbidden'),
                code: Response::HTTP_FORBIDDEN
            );
        } elseif ($loan->lender_id === $current_user_id && ($data['status'] !== (LoanStatusEnum::Approved)->value && $data['status'] !== (LoanStatusEnum::Rejected)->value && $data['status'] !== (LoanStatusEnum::Returned)->value)) {
            throw new ApiException(
                message: trans(key: 'errors.forbidden'),
                code: Response::HTTP_FORBIDDEN
            );
        }

        if ($loan->lender_id === $current_user_id && $data['status'] === (LoanStatusEnum::Approved)->value && $book_user->status === (BookUserStatusEnum::Borrowed)->value) {
            throw new ApiException(
                message: trans(key: 'errors.book.is_borrowed'),
                code: Response::HTTP_FORBIDDEN
            );
        }

        DB::beginTransaction();

        try {
            $loan_updated = $this->update_loan_status_use_case->handle(loan_id: $loan->id, status: $data['status']);

            if ($loan_updated->status === LoanStatusEnum::Approved || $loan_updated->status === LoanStatusEnum::Returned) {
                if ($book_user->status === (BookUserStatusEnum::Borrowed)->value && $loan_updated->status === LoanStatusEnum::Returned) {
                    $this->update_book_user_use_case->handle(
                        data: ['status' => BookUserStatusEnum::Available],
                        book_user: $book_user
                    );
                } elseif ($loan_updated->status === LoanStatusEnum::Approved) {
                    if ($book_user->quantity === 1) {
                        $this->update_book_user_use_case->handle(
                            data: ['status' => BookUserStatusEnum::Borrowed],
                            book_user: $book_user
                        );
                    } else {
                        $active_loans = $this->get_loan_use_case->handle(search_criteria: ['lender_id' => $loan_updated->lender_id, 'book_id' => $loan_updated->book_id]);

                        // Get the number of active loans for the book. This means with status different from Returned, Cancelled or Rejected
                        $active_loans_count = $active_loans->filter(function ($loan) {
                            return $loan->status !== LoanStatusEnum::Returned && $loan->status !== LoanStatusEnum::Cancelled && $loan->status !== LoanStatusEnum::Rejected;
                        })->count();

                        if ($active_loans_count === $book_user->quantity) {
                            $this->update_book_user_use_case->handle(
                                data: ['status' => BookUserStatusEnum::Borrowed],
                                book_user: $book_user
                            );
                        }
                    }
                }
            }
        } catch (Exception|Throwable $e) {
            DB::rollBack();

            throw $e;
        }

        DB::commit();

        return $loan_updated;
    }
}
