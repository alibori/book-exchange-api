<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Loan;

use App\Exceptions\ApiException;
use App\Http\Concerns\HasLogs;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Loan\RequestLoanRequest;
use App\Http\Resources\Api\V1\LoanResource;
use App\Http\Responses\MessageResponse;
use App\Http\Responses\ResourceResponse;
use App\Services\Api\V1\Loan\LoanApiService;
use Exception;
use Illuminate\Http\Request;
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
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
