<?php

declare(strict_types=1);

namespace App\Http\Responses;

use App\Http\Responses\Concerns\ReturnsJsonResponse;
use Illuminate\Contracts\Support\Responsable;
use Symfony\Component\HttpFoundation\Response;

final class MessageResponse implements Responsable
{
    use ReturnsJsonResponse;

    /**
     * @param array $data
     * @param int $status
     */
    public function __construct(
        private array $data,
        private int $status = Response::HTTP_OK,
    ) {
    }
}
