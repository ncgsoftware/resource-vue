<?php

namespace Database\Seeders;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class TestingUserRolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create user permissions
        Permission::create(['name' => PermissionsEnum::VIEW_ALL_USERS->value]);
        Permission::create(['name' => PermissionsEnum::VIEW_USER->value]);
        Permission::create(['name' => PermissionsEnum::CREATE_USER->value]);
        Permission::create(['name' => PermissionsEnum::UPDATE_USER->value]);
        Permission::create(['name' => PermissionsEnum::DELETE_USER->value]);

        // create resource permissions
        Permission::create(['name' => PermissionsEnum::VIEW_ALL_RESOURCES->value]);
        Permission::create(['name' => PermissionsEnum::VIEW_RESOURCE->value]);
        Permission::create(['name' => PermissionsEnum::CREATE_RESOURCE->value]);
        Permission::create(['name' => PermissionsEnum::UPDATE_RESOURCE->value]);
        Permission::create(['name' => PermissionsEnum::UPDATE_OWN_RESOURCE->value]);
        Permission::create(['name' => PermissionsEnum::DELETE_RESOURCE->value]);
        Permission::create(['name' => PermissionsEnum::DELETE_OWN_RESOURCE->value]);

        Permission::create(['name' => PermissionsEnum::NO_PERMISSIONS->value]);

        $superAdminRole = Role::create(['name' => RolesEnum::SUPER_ADMIN->value]);

        // create roles and assign existing permissions
        $adminRole = Role::create(['name' => RolesEnum::ADMINISTRATOR->value]);
        $adminRole->givePermissionTo(PermissionsEnum::VIEW_ALL_USERS);
        $adminRole->givePermissionTo(PermissionsEnum::VIEW_USER);
        $adminRole->givePermissionTo(PermissionsEnum::CREATE_USER);
        $adminRole->givePermissionTo(PermissionsEnum::UPDATE_USER);
        $adminRole->givePermissionTo(PermissionsEnum::DELETE_USER);

        $adminRole->givePermissionTo(PermissionsEnum::VIEW_ALL_RESOURCES);
        $adminRole->givePermissionTo(PermissionsEnum::VIEW_RESOURCE);
        $adminRole->givePermissionTo(PermissionsEnum::CREATE_RESOURCE);
        $adminRole->givePermissionTo(PermissionsEnum::UPDATE_RESOURCE);
        $adminRole->givePermissionTo(PermissionsEnum::UPDATE_OWN_RESOURCE);
        $adminRole->givePermissionTo(PermissionsEnum::DELETE_RESOURCE);
        $adminRole->givePermissionTo(PermissionsEnum::DELETE_OWN_RESOURCE);

        $managerRole = Role::create(['name' => RolesEnum::MANAGER->value]);
        $managerRole->givePermissionTo(PermissionsEnum::VIEW_USER);
        $managerRole->givePermissionTo(PermissionsEnum::CREATE_USER);
        $managerRole->givePermissionTo(PermissionsEnum::DELETE_USER);

        $managerRole->givePermissionTo(PermissionsEnum::VIEW_ALL_RESOURCES);
        $managerRole->givePermissionTo(PermissionsEnum::VIEW_RESOURCE);
        $managerRole->givePermissionTo(PermissionsEnum::CREATE_RESOURCE);
        $managerRole->givePermissionTo(PermissionsEnum::UPDATE_RESOURCE);
        $managerRole->givePermissionTo(PermissionsEnum::UPDATE_OWN_RESOURCE);
        $managerRole->givePermissionTo(PermissionsEnum::DELETE_RESOURCE);
        $managerRole->givePermissionTo(PermissionsEnum::DELETE_OWN_RESOURCE);

        $moderatorRole = Role::create(['name' => RolesEnum::MODERATOR->value]);
        $moderatorRole->givePermissionTo(PermissionsEnum::VIEW_USER);

        $moderatorRole->givePermissionTo(PermissionsEnum::VIEW_ALL_RESOURCES);
        $moderatorRole->givePermissionTo(PermissionsEnum::VIEW_RESOURCE);
        $moderatorRole->givePermissionTo(PermissionsEnum::CREATE_RESOURCE);
        $moderatorRole->givePermissionTo(PermissionsEnum::UPDATE_RESOURCE);
        $moderatorRole->givePermissionTo(PermissionsEnum::DELETE_OWN_RESOURCE);

        $registeredUserRole = Role::create(['name' => RolesEnum::REGISTERED_USER->value]);
        $registeredUserRole->givePermissionTo(PermissionsEnum::VIEW_ALL_RESOURCES);
        $registeredUserRole->givePermissionTo(PermissionsEnum::VIEW_RESOURCE);
        $registeredUserRole->givePermissionTo(PermissionsEnum::CREATE_RESOURCE);
        $registeredUserRole->givePermissionTo(PermissionsEnum::UPDATE_OWN_RESOURCE);

        $unverifiedUserRole = Role::create(['name' => RolesEnum::UNVERIFIED_USER->value]);
        $unverifiedUserRole->givePermissionTo(PermissionsEnum::NO_PERMISSIONS);

        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'sa@example.com',
            'profile_photo_path' => 'profile-photos/QTTqsSelOQPcRhYbY1QpYAjnoGkVSJdQ6QvsqHHC.png',
        ]);
        $user->assignRole($superAdminRole);

        $user = User::factory()->create([
            'name' => 'Super Admin 2',
            'email' => 'sa2@example.com',
            'profile_photo_path' => 'profile-photos/QTTqsSelOQPcRhYbY1QpYAjnoGkVSJdQ6QvsqHHC.png',
        ]);
        $user->assignRole($superAdminRole);

        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'profile_photo_path' => 'profile-photos/O98ssPD7Q6U20okjc2mjaCygWdo7IX3KXW9hJv9z.png',
        ]);
        $user->assignRole($adminRole);

        $user = User::factory()->create([
            'name' => 'Administrator 2',
            'email' => 'admin2@example.com',
            'profile_photo_path' => 'profile-photos/O98ssPD7Q6U20okjc2mjaCygWdo7IX3KXW9hJv9z.png',
        ]);
        $user->assignRole($adminRole);

        $user = User::factory()->create([
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'profile_photo_path' => 'profile-photos/mRHZkhBSBB61UodApJAsZojOnTqoHm2L0LiTXwpR.png',
        ]);
        $user->assignRole($managerRole);

        $user = User::factory()->create([
            'name' => 'Manager 2',
            'email' => 'manager2@example.com',
            'profile_photo_path' => 'profile-photos/mRHZkhBSBB61UodApJAsZojOnTqoHm2L0LiTXwpR.png',
        ]);
        $user->assignRole($managerRole);

        $user = User::factory()->create([
            'name' => 'Moderator',
            'email' => 'moderator@example.com',
            'profile_photo_path' => 'profile-photos/MKL3HrDHBOq3S2cvLJ0Ih6lGgpCJGYjvD3YDZADj.png',
        ]);
        $user->assignRole($moderatorRole);

        $user = User::factory()->create([
            'name' => 'Moderator 2',
            'email' => 'moderator2@example.com',
            'profile_photo_path' => 'profile-photos/MKL3HrDHBOq3S2cvLJ0Ih6lGgpCJGYjvD3YDZADj.png',
        ]);
        $user->assignRole($moderatorRole);

        $user = User::factory()->create([
            'name' => 'Registered User', // Registered and Verified
            'email' => 'reg@example.com',
            'profile_photo_path' => 'profile-photos/CQWOpDDLnwfZb4a3B1Ld9mXDuiJw74pjQPy1u6nm.png',
        ]);
        $user->assignRole($registeredUserRole);

        $user = User::factory()->create([
            'name' => 'Registered User 2', // Registered and Verified
            'email' => 'reg2@example.com',
            'profile_photo_path' => 'profile-photos/CQWOpDDLnwfZb4a3B1Ld9mXDuiJw74pjQPy1u6nm.png',
        ]);
        $user->assignRole($registeredUserRole);

        $user = User::factory()->create([
            'name' => 'Unverified User', // Registered, but unverified
            'email' => 'unver@example.com',
            'email_verified_at' => null,
            'profile_photo_path' => 'profile-photos/s1dQR5uljkSDKNoRpEAOFikYSbwpJpehC9p3FwrY.png',
        ]);
        $user->assignRole($unverifiedUserRole);

        $user = User::factory()->create([
            'name' => 'Unverified User 2', // Registered, but unverified
            'email' => 'unver2@example.com',
            'email_verified_at' => null,
            'profile_photo_path' => 'profile-photos/s1dQR5uljkSDKNoRpEAOFikYSbwpJpehC9p3FwrY.png',
        ]);
        $user->assignRole($unverifiedUserRole);
    }
}
