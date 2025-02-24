<?php

declare(strict_types=1);

use App\Enums\RolesEnum;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('requires authentication', function () {
    get(route('admin.dashboard'))
        ->assertRedirect(route('login'));
});

it('should return the correct component', function () {
    $superAdmin = User::role(RolesEnum::SUPER_ADMIN)->first();

    actingAs($superAdmin)
        ->get(route('admin.dashboard'))
        ->assertComponent('Admin/Index');
});

it('allows managers, admins, and super admins to access dashboard', function (User $user, string $error) {
    actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertComponent('Admin/Index');
})->with([
    [fn () => User::role(RolesEnum::SUPER_ADMIN)->first(), 'Super Administrator'],
    [fn () => User::role(RolesEnum::ADMINISTRATOR)->first(), 'Administrator'],
    [fn () => User::role(RolesEnum::MANAGER)->first(), 'Manager'],
]);

// If User implements MustVerifyEmail then 'AdminController/RedirectsUnverifiedEmailUsersTest' will be the test for 'Unverified' Role users
it('disallows moderators, registered users, and unverified users to see user list',
    function (User $user, string $error) {
        actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    })->with([
        [fn () => User::role(RolesEnum::MODERATOR)->first(), 'Moderator'],
        [fn () => User::role(RolesEnum::REGISTERED_USER)->first(), 'Registered User'],
        // [fn () => User::role(RolesEnum::UNVERIFIED_USER)->first(), 'Unverified User'],
    ]);
