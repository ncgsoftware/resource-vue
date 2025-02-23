<?php

namespace Database\Seeders;

// use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserRolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create user permissions
        Permission::create(['name' => 'View All Users']);
        Permission::create(['name' => 'View Users']);
        Permission::create(['name' => 'Create Users']);
        Permission::create(['name' => 'Update Users']);
        Permission::create(['name' => 'Delete Users']);

        // create resource permissions
        Permission::create(['name' => 'View All Resources']);
        Permission::create(['name' => 'View Resources']);
        Permission::create(['name' => 'Create Resources']);
        Permission::create(['name' => 'Update Resources']);
        Permission::create(['name' => 'Update Own Resources']);
        Permission::create(['name' => 'Delete Resources']);
        Permission::create(['name' => 'Delete Own Resources']);

        Permission::create(['name' => 'None']);

        $superAdminRole = Role::create(['name' => 'Super Admin']);

        // create roles and assign existing permissions
        $adminRole = Role::create(['name' => 'Administrator']);
        $adminRole->givePermissionTo('View All Users');
        $adminRole->givePermissionTo('View Users');
        $adminRole->givePermissionTo('Create Users');
        $adminRole->givePermissionTo('Update Users');
        $adminRole->givePermissionTo('Delete Users');

        $adminRole->givePermissionTo('View All Resources');
        $adminRole->givePermissionTo('View Resources');
        $adminRole->givePermissionTo('Create Resources');
        $adminRole->givePermissionTo('Update Resources');
        $adminRole->givePermissionTo('Update Own Resources');
        $adminRole->givePermissionTo('Delete Resources');
        $adminRole->givePermissionTo('Delete Own Resources');

        $managerRole = Role::create(['name' => 'Manager']);
        $managerRole->givePermissionTo('View Users');
        $managerRole->givePermissionTo('Update Users');
        $managerRole->givePermissionTo('Delete Users');

        $managerRole->givePermissionTo('View All Resources');
        $managerRole->givePermissionTo('View Resources');
        $managerRole->givePermissionTo('Create Resources');
        $managerRole->givePermissionTo('Update Resources');
        $managerRole->givePermissionTo('Update Own Resources');
        $managerRole->givePermissionTo('Delete Resources');
        $managerRole->givePermissionTo('Delete Own Resources');

        $moderatorRole = Role::create(['name' => 'Moderator']);
        $moderatorRole->givePermissionTo('View Users');

        $moderatorRole->givePermissionTo('View All Resources');
        $moderatorRole->givePermissionTo('View Resources');
        $moderatorRole->givePermissionTo('Create Resources');
        $moderatorRole->givePermissionTo('Update Resources');
        $moderatorRole->givePermissionTo('Update Own Resources');

        $registeredUserRole = Role::create(['name' => 'Registered']);
        $registeredUserRole->givePermissionTo('View All Resources');
        $registeredUserRole->givePermissionTo('View Resources');
        $registeredUserRole->givePermissionTo('Create Resources');
        $registeredUserRole->givePermissionTo('Update Own Resources');

        $unverifiedUserRole = Role::create(['name' => 'Unverified']);
        $unverifiedUserRole->givePermissionTo('None');

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
