<?php

namespace App\Traits;

use App\Enums\RolesEnum;
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
        $rolesToReturn = [
            RolesEnum::UNVERIFIED_USER->value,
            RolesEnum::REGISTERED_USER->value,
            RolesEnum::MODERATOR->value,
            RolesEnum::MANAGER->value,
        ];

        if ($user->hasRole(RolesEnum::ADMINISTRATOR)) {
            $rolesToReturn[] = RolesEnum::ADMINISTRATOR->value;
        }

        if ($user->hasRole(RolesEnum::SUPER_ADMIN)) {
            $rolesToReturn[] = RolesEnum::ADMINISTRATOR->value;
            $rolesToReturn[] = RolesEnum::SUPER_ADMIN->value;
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
        $rolesToReturn = [
            RolesEnum::UNVERIFIED_USER->value,
            RolesEnum::REGISTERED_USER->value,
            RolesEnum::MODERATOR->value,
        ];

        if ($user->hasRole(RolesEnum::ADMINISTRATOR)) {
            $rolesToReturn[] = RolesEnum::MANAGER->value;
        }

        if ($user->hasRole(RolesEnum::SUPER_ADMIN)) {
            $rolesToReturn[] = RolesEnum::MANAGER->value;
            $rolesToReturn[] = RolesEnum::ADMINISTRATOR->value;
        }

        return array_unique($rolesToReturn);
    }
}
