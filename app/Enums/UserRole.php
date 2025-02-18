<?php

namespace App\Enums;

enum UserRole : int
{
    case SUPER_ADMIN = 0;
    case ADMIN = 1;
    case MANAGER = 2;
    case MODERATOR = 3;
    case REGISTERED_USER = 4;
    case UNVERIFIED_USER = 5;

    public function getDescription(): string
    {
        return match ($this) {
            UserRole::SUPER_ADMIN => 'Super Admin',
            UserRole::ADMIN => 'Administrator',
            UserRole::MANAGER => 'Manager',
            UserRole::MODERATOR => 'Moderator',
            UserRole::REGISTERED_USER => 'Registered User',
            UserRole::UNVERIFIED_USER => 'Unregistered User',
        };
    }
}
