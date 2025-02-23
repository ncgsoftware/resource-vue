<?php

namespace App\Traits;

use App\Models\User;

trait DetermineRoleHierarchy
{
    /**
     * Returns Roles a user is allowed to see.
     * They may only see other users with same Role or less than themselves.
     *
     * @return string[]
     */
    public function determineRolesUserIsAllowedToDisplay(User $user): array
    {
        $rolesToReturn = ['Unverified', 'Registered', 'Moderator', 'Manager'];

        if ($user->hasRole('Administrator')) {
            $rolesToReturn[] = 'Administrator';
        }

        if ($user->hasRole('Super Admin')) {
            $rolesToReturn[] = 'Administrator';
            $rolesToReturn[] = 'Super Admin';
        }

        return array_unique($rolesToReturn);
    }

    /**
     * Returns Roles a user is allowed to see/manipulate.
     * They may only see/manipulate other users with same Role or less than themselves.
     *
     * @return string[]
     */
    public function determineRolesUserIsAllowedToManipulate(User $user): array
    {
        $rolesToReturn = ['Unverified', 'Registered', 'Moderator'];

        if ($user->hasRole('Administrator')) {
            $rolesToReturn[] = 'Manager';
        }

        if ($user->hasRole('Super Admin')) {
            $rolesToReturn[] = 'Manager';
            $rolesToReturn[] = 'Administrator';
        }

        return array_unique($rolesToReturn);
    }
}
