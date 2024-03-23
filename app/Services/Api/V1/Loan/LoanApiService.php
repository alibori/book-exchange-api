<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Loan;

use App\Enums\BookUserStatusEnum;
use App\Enums\LoanStatusEnum;
use App\Exceptions\ApiException;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;
use Src\Book\Application\UseCases\GetBookUserUseCase;
use Src\Book\Application\UseCases\UpdateBookUserUseCase;
use Src\Loan\Application\UseCases\CreateLoanUseCase;
use Symfony\Component\HttpFoundation\Response;

final class LoanApiService
{
    public function __construct(
        private readonly GetBookUserUseCase $get_book_user_use_case,
        private readonly UpdateBookUserUseCase $update_book_user_use_case,
        private readonly CreateLoanUseCase $create_loan_use_case
    )
    {}

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
}
