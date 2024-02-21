<?php

declare(strict_types=1);

namespace App\Http\Responses\Concerns;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @property-read array $data
 * @property-read int $status
 */
trait ReturnsJsonResponse
{
    public function toResponse($request): Response
    {
        return new JsonResponse(
            data: $this->data,
            status: $this->status,
        );
    }
}
