<?php

declare(strict_types=1);

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Support\Facades\URL;

it('event Illuminate\Auth\Events\Verified to update user role from unverified to registered', function () {
    $registeredRole = User::role(RolesEnum::REGISTERED_USER)->first();
    $user = User::role(RolesEnum::UNVERIFIED_USER)->first();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    $this->actingAs($user)->get($verificationUrl);

    $usersNewRoles = User::role(RolesEnum::REGISTERED_USER)->firstOrFail();

    expect($user->fresh()
        ->hasVerifiedEmail())->toBeTrue()
        ->and($usersNewRoles->id)->toBe($registeredRole->id);
});
