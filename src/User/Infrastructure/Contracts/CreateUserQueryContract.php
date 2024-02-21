<?php

declare(strict_types=1);

namespace Src\User\Infrastructure\Contracts;

use App\Models\User;

interface CreateUserQueryContract
{
    public function handle(array $data): User;
}
