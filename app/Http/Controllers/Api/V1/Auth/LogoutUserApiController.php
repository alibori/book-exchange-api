<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Concerns\HasLogs;
use App\Http\Controllers\Controller;
use App\Http\Responses\MessageResponse;
use App\Services\Api\V1\Auth\AuthApiService;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * @tags Users
 */
final class LogoutUserApiController extends Controller
{
    use HasLogs;

    public function __construct(private readonly AuthApiService $auth_api_service)
    {}

    /**
     * DELETE /api/v1/logout
     * Endpoint to log out a User
     *
     * @return MessageResponse
     */
    public function __invoke(): MessageResponse
    {
        try {
            $this->auth_api_service->logoutUser();
        }  catch (Exception|Throwable $e) {
            $this->logError(exception: $e, channel: 'api');

            return new MessageResponse(
                data: ['error' => trans(key: 'errors.unknown_error')],
                status: Response::HTTP_SERVICE_UNAVAILABLE
            );
        }

        return new MessageResponse(
            data: ['message' => 'User logged out successfully']
        );
    }
}
