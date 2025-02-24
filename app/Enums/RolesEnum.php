<?php

namespace App\Enums;

enum RolesEnum: string
{
    case SUPER_ADMIN = 'super-admin';
    case ADMINISTRATOR = 'administrator';
    case MANAGER = 'manager';
    case MODERATOR = 'moderator';
    case REGISTERED_USER = 'registered-user';
    case UNVERIFIED_USER = 'unverified-user';

    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Writers',
            self::ADMINISTRATOR => 'Editors',
            self::MANAGER => 'Managers',
            self::MODERATOR => 'Moderators',
            self::REGISTERED_USER => 'Registered User',
            self::UNVERIFIED_USER => 'Unverified User',
        };
    }
}
