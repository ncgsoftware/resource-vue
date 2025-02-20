<?php
    declare(strict_types=1);

    use App\Models\Role;
    use App\Models\User;
    use function Pest\Laravel\actingAs;
    use function Pest\Laravel\get;

    it('requires authentication', function () {
        get(route('admin.dashboard'))
            ->assertRedirect(route('login'));
    });

    it('should return the correct component', function () {
        $adminRole = Role::where(['auth_code' => 'super-admin'])->first();
        $superAdmin = User::factory()->for($adminRole)->create();

        actingAs($superAdmin)
            ->get(route('admin.dashboard'))
            ->assertComponent('Admin/Index');
    });

    it('allows managers, admins, and super admins to access dashboard', function (User $user, string $error) {
        actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertComponent('Admin/Index');
    })->with([
        [fn() => User::factory()->create(['role_id' => Role::where(['auth_code' => 'super-admin'])->first()]), 'Super Administrator'],
        [fn() => User::factory()->create(['role_id' => Role::where(['auth_code' => 'admin'])->first()]), 'Administrator'],
        [fn() => User::factory()->create(['role_id' => Role::where(['auth_code' => 'manager'])->first()]), 'Manager']
    ]);

    it('disallows moderators, registered users, and unverified users to see user list',
        function (User $user, string $error) {
            actingAs($user)
                ->get(route('admin.dashboard'))
                ->assertForbidden();
        })->with([
        [fn() => User::factory()->create(['role_id' => Role::where(['auth_code' => 'moderator'])->first()]), 'Moderator'],
        [fn() => User::factory()->create(['role_id' => Role::where(['auth_code' => 'registered'])->first()]), 'Registered User'],
        [fn() => User::factory()->create(['role_id' => Role::where(['auth_code' => 'unverified'])->first()]), 'Unverified User']
    ]);
