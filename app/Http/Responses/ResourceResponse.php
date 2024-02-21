<?php

declare(strict_types=1);

namespace App\Http\Responses;

use App\Http\Responses\Concerns\ReturnsJsonResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

final class ResourceResponse implements Responsable
{
    use ReturnsJsonResponse;

    /**
     * @param JsonResource $data
     * @param int $status
     */
    public function __construct(
        private readonly JsonResource $data,
        private readonly int $status = Response::HTTP_OK,
    ) {
    }
}
