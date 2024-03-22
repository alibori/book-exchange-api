<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Admin;
use App\Models\Loan;
use App\Models\User;

final class LoanPolicy
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
    public function delete(User|Admin $user, Loan $loan): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User|Admin $user, Loan $loan): bool
    {
        return false;
    }
}
