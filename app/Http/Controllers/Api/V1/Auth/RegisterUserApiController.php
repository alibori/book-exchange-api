<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Concerns\HasLogs;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\RegisterUserRequest;
use App\Http\Resources\Api\V1\AuthResource;
use App\Http\Responses\MessageResponse;
use App\Http\Responses\ResourceResponse;
use App\Services\Api\V1\Auth\AuthApiService;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use Throwable;

final class RegisterUserApiController extends Controller
{
    use HasLogs;

    public function __construct(private readonly AuthApiService $auth_api_service)
    {}

    /**
     * POST /api/v1/auth/register
     * Endpoint to register a new User
     *
     * @param RegisterUserRequest $request
     * @return ResourceResponse|MessageResponse
     */
    public function __invoke(RegisterUserRequest $request): ResourceResponse|MessageResponse
    {
        try {
            $response = $this->auth_api_service->registerUser(data: $request->validated());
        } catch (Exception|Throwable $e) {
            $this->logError(exception: $e, channel: 'api');

            return new MessageResponse(
                data: ['error' => trans(key: 'errors.unknown_error')],
                status: Response::HTTP_SERVICE_UNAVAILABLE
            );
        }

        return new ResourceResponse(
            data: AuthResource::make($response),
            status: Response::HTTP_CREATED
        );
    }
}
