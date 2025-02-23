<?php

declare(strict_types=1);

use App\Http\Controllers\UserController;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserAdministrationResource;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Inertia\Testing\AssertableInertia as Assert;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\withoutExceptionHandling;

covers(UserController::class);

it('requires authentication', function () {
    get(route('admin.users.index'))
        ->assertRedirect(route('login'));
});

it('should return the correct component', function () {
    $superAdmin = User::role('Super Admin')->first();

    actingAs($superAdmin)
        ->get(route('admin.users.index'))
        ->assertComponent('Admin/Users/Index');
});

it('allows managers, admins, and super admins to access user list', function (User $user, string $error) {
    actingAs($user)
        ->get(route('admin.users.index'))
        ->assertComponent('Admin/Users/Index');
})->with([
    [fn () => User::role('Super Admin')->first(), 'Super Administrator'],
    [fn () => User::role('Administrator')->first(), 'Administrator'],
    [fn () => User::role('Manager')->first(), 'Manager'],
]);

// If User implements MustVerifyEmail then 'AdminController/RedirectsUnverifiedEmailUsersTest' will be the test for 'Unverified' Role users
it('disallows moderators, registered users, and unverified users to see user list',
    function (User $user, string $error) {
        actingAs($user)
            ->get(route('admin.users.index'))
            ->assertForbidden();
    })->with([
        [fn () => User::role('Moderator')->first(), 'Moderator'],
        [fn () => User::role('Registered')->first(), 'Registered User'],
        // [fn () => User::role('Unverified')->first(), 'Unverified User'],
    ]);

it('passes a users property to the view', function () {
    $superAdmin = User::role('Super Admin')->first();

    actingAs($superAdmin)
        ->get(route('admin.users.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->has('users')
        );
});

it('gets paginated resource', function () {
    $superAdmin = User::role('Super Admin')->first();

    actingAs($superAdmin)
        ->get(route('admin.users.index'))
        ->assertHasResource('users',
            UserAdministrationResource::collection(User::paginate())
        );
});

it('passes Roles to the view', function () {
    $superAdmin = User::role('Super Admin')->first();

    $roles = Role::all();

    actingAs($superAdmin)
        ->get(route('admin.users.index'))
        ->assertHasResource('roles', RoleResource::collection($roles));
});

it('passes selected role to the view', function () {
    $superAdmin = User::role('Super Admin')->first();

    $selectedRole = Role::where(['name' => 'manager'])->first();

    actingAs($superAdmin)
        ->get(route('admin.users.index', ['role' => $selectedRole]))
        ->assertHasResource('selectedRole', RoleResource::make($selectedRole));
});

//    it('it can filter to a role', function () {
//        withoutExceptionHandling();
//        $adminRole = Role::factory()->create(['auth_code' => 'super-admin']);
//        $superAdmin = User::factory()->for($adminRole)->create();
//
//        $users = User::factory(2)->for($adminRole)->create();
//
//        $users->load('role');
//
//        $managerRole = Role::factory()->create(['auth_code' => 'manager']);
//
//        User::factory(3)->for($managerRole)->create();
//
//        actingAs($superAdmin)
//            ->get(route('admin.users.index', ['role' => $adminRole]))
//            ->assertHasPaginatedResource('users', UserAdministrationResource::collection($users->reverse()));
//    });
