<?php

namespace App\Enums;

enum PermissionsEnum: string
{
    // Administrator Permissions
    case VIEW_ALL_USERS = 'view-all-users';
    case VIEW_USER = 'view-user';
    case CREATE_USER = 'create-user';
    case UPDATE_USER = 'update-user';
    case DELETE_USER = 'delete-user';

    // Resource Permissions
    case VIEW_ALL_RESOURCES = 'view-all-resources';
    case VIEW_RESOURCE = 'view-resource';
    case CREATE_RESOURCE = 'create-resource';
    case UPDATE_RESOURCE = 'update-resource';
    case UPDATE_OWN_RESOURCE = 'update-own-resource';
    case DELETE_RESOURCE = 'delete-resource';
    case DELETE_OWN_RESOURCE = 'delete-own-resource';
    case NO_PERMISSIONS = 'no-permissions';

    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            // Administration
            self::VIEW_ALL_USERS => 'View All Users',
            self::VIEW_USER => 'View User',
            self::CREATE_USER => 'Create User',
            self::UPDATE_USER => 'Edit User',
            self::DELETE_USER => 'Delete User',

            // Resources
            self::VIEW_ALL_RESOURCES => 'View All Resources',
            self::VIEW_RESOURCE => 'View Resource',
            self::CREATE_RESOURCE => 'Create Resource',
            self::UPDATE_RESOURCE => 'Update Resource',
            self::UPDATE_OWN_RESOURCE => 'Update Own Resource',
            self::DELETE_RESOURCE => 'Delete Resource',
            self::DELETE_OWN_RESOURCE => 'Delete Own Resource',

            // Has no permissions
            self::NO_PERMISSIONS => 'No Permissions',
        };
    }
}
