<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Book;

use App\Http\Concerns\HasLogs;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Book\BookApplicationRequest;
use App\Http\Requests\Api\V1\Book\ListBooksRequest;
use App\Http\Resources\Api\V1\BookApplicationResource;
use App\Http\Resources\Api\V1\BookResourceCollection;
use App\Http\Responses\MessageResponse;
use App\Http\Responses\ResourceResponse;
use App\Services\Api\V1\Book\BookApiService;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class BookApiController extends Controller
{
    use HasLogs;

    public function __construct(private readonly BookApiService $book_api_service)
    {}

    /**
     * GET /api/v1/books
     * Endpoint to get a paginated filtered list of books.
     *
     * @param ListBooksRequest $request
     * @return ResourceResponse|MessageResponse
     */
    public function index(ListBooksRequest $request): ResourceResponse|MessageResponse
    {
        try {
            $response = $this->book_api_service->listBooks(data: $request->validated());
        } catch (Exception|Throwable $e) {
            $this->logError(exception: $e, channel: 'api');

            return new MessageResponse(
                data: ['error' => trans(key: 'errors.unknown_error')],
                status: Response::HTTP_SERVICE_UNAVAILABLE
            );
        }

        return new ResourceResponse(
            data: new BookResourceCollection(resource: $response),
            status: Response::HTTP_OK
        );
    }

    /**
     * POST /api/v1/books
     * Endpoint to make a book application.
     *
     * @param BookApplicationRequest $request
     * @return ResourceResponse|MessageResponse
     */
    public function store(BookApplicationRequest $request): ResourceResponse|MessageResponse
    {
        try {
            $response = $this->book_api_service->bookApply(data: $request->validated());
        } catch (Exception|Throwable $e) {
            $this->logError(exception: $e, channel: 'api');

            return new MessageResponse(
                data: ['error' => trans(key: 'errors.unknown_error')],
                status: Response::HTTP_SERVICE_UNAVAILABLE
            );
        }

        return new ResourceResponse(
            data: BookApplicationResource::make($response),
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
