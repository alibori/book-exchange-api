<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Exceptions\ApiException;
use App\Http\Concerns\HasLogs;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginUserRequest;
use App\Http\Resources\Api\V1\AuthResource;
use App\Http\Responses\MessageResponse;
use App\Http\Responses\ResourceResponse;
use App\Services\Api\V1\Auth\AuthApiService;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class LoginUserApiController extends Controller
{
    use HasLogs;

    public function __construct(private readonly AuthApiService $auth_api_service)
    {}

    /**
     * POST /api/v1/auth/login
     * Endpoint to log in a User with email and password
     *
     * @param LoginUserRequest $request
     * @return ResourceResponse|MessageResponse
     */
    public function __invoke(LoginUserRequest $request): ResourceResponse|MessageResponse
    {
        try {
            $response = $this->auth_api_service->loginUser(data: $request->validated());
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
            data: AuthResource::make($response),
            status: Response::HTTP_OK
        );
    }
}
