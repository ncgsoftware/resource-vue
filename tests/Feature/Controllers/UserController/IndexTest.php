<?php
    declare(strict_types=1);

    use App\Http\Resources\RoleResource;
    Use App\Models\Role;
    use App\Http\Resources\UserAdministrationResource;
    use App\Models\User;
    use function Pest\Laravel\actingAs;
    use function Pest\Laravel\get;
    use Inertia\Testing\AssertableInertia as Assert;
    use function Pest\Laravel\withoutExceptionHandling;

    it('requires authentication', function () {
        get(route('admin.users.index'))
            ->assertRedirect(route('login'));
    });

    it('should return the correct component', function () {
        $adminRole = Role::where(['auth_code' => 'super-admin'])->first();
        $superAdmin = User::factory()->for($adminRole)->create();

        actingAs($superAdmin)
            ->get(route('admin.users.index'))
            ->assertComponent('Admin/Users/Index');
    });

    it('allows managers, admins, and super admins to access user list', function (User $user, string $error) {
        actingAs($user)
            ->get(route('admin.users.index'))
            ->assertComponent('Admin/Users/Index');
    })->with([
        [fn() => User::factory()->create(['role_id' => Role::where(['auth_code' => 'super-admin'])->first()]), 'Super Administrator'],
        [fn() => User::factory()->create(['role_id' => Role::where(['auth_code' => 'admin'])->first()]), 'Administrator'],
        [fn() => User::factory()->create(['role_id' => Role::where(['auth_code' => 'manager'])->first()]), 'Manager']
    ]);

    it('disallows moderators, registered users, and unverified users to see user list',
        function (User $user, string $error) {
            actingAs($user)
                ->get(route('admin.users.index'))
                ->assertForbidden();
        })->with([
        [fn() => User::factory()->create(['role_id' => Role::where(['auth_code' => 'moderator'])->first()]), 'Moderator'],
        [fn() => User::factory()->create(['role_id' => Role::where(['auth_code' => 'registered'])->first()]), 'Registered User'],
        [fn() => User::factory()->create(['role_id' => Role::where(['auth_code' => 'unverified'])->first()]), 'Unverified User']
    ]);

    it('passes a users property to the view', function () {
        $adminRole = Role::where(['auth_code' => 'super-admin'])->first();
        $superAdmin = User::factory()->for($adminRole)->create();

        actingAs($superAdmin)
            ->get(route('admin.users.index'))
            ->assertInertia(
                fn(Assert $page) => $page
                    ->has('users')
            );
    });

    it('it gets paginated resource', function () {
        withoutExceptionHandling();
        $adminRole = Role::where(['auth_code' => 'super-admin'])->first();
        $superAdmin = User::factory()->for($adminRole)->create();

        User::factory(2)->create();

        actingAs($superAdmin)
            ->get(route('admin.users.index'))
            ->assertHasResource('users',
                UserAdministrationResource::collection(User::paginate())
            );
    });

    it('it passes Roles to the view', function () {
        $adminRole = Role::where(['auth_code' => 'super-admin'])->first();
        $superAdmin = User::factory()->for($adminRole)->create();

        $roles = Role::all();

        actingAs($superAdmin)
            ->get(route('admin.users.index'))
            ->assertHasResource('roles', RoleResource::collection($roles));
    });

    it('it passes selected role to the view', function () {
        $adminRole = Role::where(['auth_code' => 'super-admin'])->first();
        $superAdmin = User::factory()->for($adminRole)->create();

        $selectedRole = Role::where(['auth_code' => 'manager'])->first();

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



