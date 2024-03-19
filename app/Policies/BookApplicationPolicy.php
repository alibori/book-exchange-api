<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Admin;
use App\Models\BookApplication;
use App\Models\User;

final class BookApplicationPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User|Admin $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User|Admin $user, BookApplication $bookApplication): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User|Admin $user, BookApplication $bookApplication): bool
    {
        return false;
    }
}
