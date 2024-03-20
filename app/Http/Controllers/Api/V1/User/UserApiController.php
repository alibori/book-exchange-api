<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User;

use App\Exceptions\ApiException;
use App\Http\Concerns\HasLogs;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Common\PaginationRequest;
use App\Http\Requests\Api\V1\User\UpdateUserRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Http\Resources\Api\V1\UserResourceCollection;
use App\Http\Responses\MessageResponse;
use App\Http\Responses\ResourceResponse;
use App\Services\Api\V1\User\UserApiService;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * @tags Users
 */
final class UserApiController extends Controller
{
    use HasLogs;

    public function __construct(private readonly UserApiService $user_api_service)
    {}

    /**
     * GET /api/v1/users
     * Endpoint to get a paginated list of Users
     *
     * @param PaginationRequest $request
     * @return ResourceResponse|MessageResponse
     */
    public function index(PaginationRequest $request): ResourceResponse|MessageResponse
    {
        try {
            $response = $this->user_api_service->listUsers(pagination_data: $request->validated());
        } catch (Exception|Throwable $e) {
            $this->logError(exception: $e, channel: 'api');

            return new MessageResponse(
                data: ['error' => trans(key: 'errors.unknown_error')],
                status: Response::HTTP_SERVICE_UNAVAILABLE
            );
        }

        return new ResourceResponse(
            data: new UserResourceCollection(resource: $response),
            status: Response::HTTP_OK
        );
    }

    /**
     * GET /api/v1/users/{id}
     * Endpoint to get User by id
     *
     * @param string $id
     * @return ResourceResponse|MessageResponse
     */
    public function show(string $id): ResourceResponse|MessageResponse
    {
        try {
            $response = $this->user_api_service->getUser(id: $id);
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
            data: UserResource::make($response),
            status: Response::HTTP_OK
        );
    }

    /**
     * PUT /api/v1/users/{id}
     * Endpoint to update User by id
     *
     * @param UpdateUserRequest $request
     * @param string $id
     * @return ResourceResponse|MessageResponse
     */
    public function update(UpdateUserRequest $request, string $id): ResourceResponse|MessageResponse
    {
        try {
            $response = $this->user_api_service->updateUser(
                id: $id,
                attributes: $request->validated()
            );
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
            data: UserResource::make($response),
            status: Response::HTTP_OK
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
