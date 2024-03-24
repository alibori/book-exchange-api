<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Loan;

use App\Exceptions\ApiException;
use App\Http\Concerns\HasLogs;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Loan\ListLoansRequest;
use App\Http\Requests\Api\V1\Loan\RequestLoanRequest;
use App\Http\Requests\Api\V1\Loan\UpdateLoanRequest;
use App\Http\Resources\Api\V1\LoanResource;
use App\Http\Resources\Api\V1\LoanResourceCollection;
use App\Http\Responses\MessageResponse;
use App\Http\Responses\ResourceResponse;
use App\Services\Api\V1\Loan\LoanApiService;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * @tags Loans
 */
final class LoanApiController extends Controller
{
    use HasLogs;

    public function __construct(private readonly LoanApiService $loan_api_service)
    {}

    /**
     * GET /api/v1/loans
     * Endpoint to get a paginated list of Loans where the current user is the borrower or lender
     *
     * @param ListLoansRequest $request
     * @return ResourceResponse|MessageResponse
     */
    public function index(ListLoansRequest $request): ResourceResponse|MessageResponse
    {
        try {
            $response = $this->loan_api_service->list(data: $request->validated());
        } catch (Exception|Throwable $e) {
            $this->logError(exception: $e, channel: 'api');

            return new MessageResponse(
                data: ['error' => trans(key: 'errors.unknown_error')],
                status: Response::HTTP_SERVICE_UNAVAILABLE
            );
        }

        return new ResourceResponse(
            data: new LoanResourceCollection(resource: $response),
            status: Response::HTTP_OK
        );
    }

    /**
     * POST /api/v1/loans
     * Endpoint to request a Loan
     *
     * @param RequestLoanRequest $request
     * @return ResourceResponse|MessageResponse
     */
    public function store(RequestLoanRequest $request): ResourceResponse|MessageResponse
    {
        try {
            $response = $this->loan_api_service->requestLoan($request->validated());
        } catch (ApiException|Exception|Throwable $e) {
            $this->logError(exception: $e, channel: 'api');

            if ($e instanceof ApiException) {
                return new MessageResponse(
                    data: ['error' => $e->getMessage()],
                    status: $e->getCode()
                );
            }

            return new MessageResponse(
                data: ['error' => trans(key: 'errors.unknown_error')],
                status: Response::HTTP_SERVICE_UNAVAILABLE
            );
        }

        return new ResourceResponse(
            data: LoanResource::make($response),
            status: Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * PUT /api/v1/loans/{id}
     * Endpoint to update a Loan's status
     *
     * @param UpdateLoanRequest $request
     * @param string $id
     * @return MessageResponse
     */
    public function update(UpdateLoanRequest $request, string $id): MessageResponse
    {
        try {
            $this->loan_api_service->updateLoanStatus(data: $request->validated(), loan_id: $id);
        } catch (ApiException|Exception|Throwable $e) {
            $this->logError(exception: $e, channel: 'api');

            if ($e instanceof ApiException) {
                return new MessageResponse(
                    data: ['error' => $e->getMessage()],
                    status: $e->getCode()
                );
            }

            return new MessageResponse(
                data: ['error' => trans(key: 'errors.unknown_error')],
                status: Response::HTTP_SERVICE_UNAVAILABLE
            );
        }

        return new MessageResponse(
            data: ['message' => trans(key: 'messages.loan.status_updated')],
            status: Response::HTTP_OK
        );
    }
}
