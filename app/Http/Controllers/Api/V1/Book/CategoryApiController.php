<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Book;

use App\Http\Concerns\HasLogs;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Common\PaginationRequest;
use App\Http\Resources\Api\V1\CategoryResourceCollection;
use App\Http\Responses\MessageResponse;
use App\Http\Responses\ResourceResponse;
use App\Services\Api\V1\Book\CategoryApiService;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * @tags Books
 */
final class CategoryApiController extends Controller
{
    use HasLogs;

    public function __construct(private CategoryApiService $category_api_service)
    {}

    /**
     * GET /api/v1/categories
     * Endpoint to get a paginated list of categories
     *
     * @param PaginationRequest $request
     * @return ResourceResponse|MessageResponse
     */
    public function __invoke(PaginationRequest $request): ResourceResponse|MessageResponse
    {
        try {
            $response = $this->category_api_service->listCategories(data: $request->validated());
        } catch (Exception|Throwable $e) {
            $this->logError(exception: $e, channel: 'api');

            return new MessageResponse(
                data: ['error' => trans(key: 'errors.unknown_error')],
                status: Response::HTTP_SERVICE_UNAVAILABLE
            );
        }

        return new ResourceResponse(
            data: new CategoryResourceCollection(resource: $response),
            status: Response::HTTP_OK
        );
    }
}
