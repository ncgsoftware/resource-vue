<?php

    use App\Models\Role;
    use App\Models\User;
    use Illuminate\Support\Facades\URL;
    use function PHPUnit\Framework\assertNull;

    it('event Illuminate\Auth\Events\Verified to update user role from unverified to registered', function () {
        $unverifiedRole = Role::query()->where('auth_code', 'unverified')->firstOrFail();
        $registeredRole = Role::query()->where('auth_code', 'registered')->firstOrFail();

        $user = User::factory()->for($unverifiedRole)->create(['email_verified_at' => null]);
        assertNull($user->email_verified_at);


        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $this->actingAs($user)->get($verificationUrl);

        $user->fresh();

        expect($user->fresh()
            ->hasVerifiedEmail())->toBeTrue()
            ->and($user->role_id)->toBe($registeredRole->id);
    });
