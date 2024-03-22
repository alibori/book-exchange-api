<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Book;

use App\Exceptions\ApiException;
use App\Http\Concerns\HasLogs;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Book\AddBookRequest;
use App\Http\Requests\Api\V1\Book\ListBooksRequest;
use App\Http\Resources\Api\V1\BookResourceCollection;
use App\Http\Responses\MessageResponse;
use App\Http\Responses\ResourceResponse;
use App\Services\Api\V1\Book\BookApiService;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * @tags Books
 */
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
     * Endpoint to add a Book in the User's Library.
     *
     * @param AddBookRequest $request
     * @return MessageResponse
     */
    public function store(AddBookRequest $request): MessageResponse
    {
        try {
            $this->book_api_service->addToLibrary(data: $request->validated());
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
            data: ['message' => trans(key: 'messages.book.added_to_library')],
            status: Response::HTTP_CREATED
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * DELETE /api/v1/books/{id}
     * Endpoint to remove a Book from the User's Library.
     *
     * @param string $id
     * @return MessageResponse
     */
    public function destroy(string $id): MessageResponse
    {
        try {
            $response = $this->book_api_service->removeFromLibrary(book_id: $id);
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

        if (!$response) {
            return new MessageResponse(
                data: ['error' => trans(key: 'errors.unknown_error')],
                status: Response::HTTP_SERVICE_UNAVAILABLE
            );
        }

        return new MessageResponse(
            data: ['message' => trans(key: 'messages.book.removed_from_library')],
            status: Response::HTTP_OK
        );
    }
}
