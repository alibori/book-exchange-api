<?php

declare(strict_types=1);

namespace App\Http\Concerns;

use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

trait HasLogs
{
    public function logInfo(string $message, ?string $channel): void
    {
        Log::channel(channel: $channel)->info(message: $message);
    }

    public function logError(Exception|Throwable $exception, ?string $channel): void
    {
        Log::channel(channel: $channel)->error(message: $exception->getMessage(), context: [
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
