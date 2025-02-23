<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\URL;

it('event Illuminate\Auth\Events\Verified to update user role from unverified to registered', function () {
    $registeredRole = User::role('Registered')->first();
    $user = User::role('Unverified')->first();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    $this->actingAs($user)->get($verificationUrl);

    $usersNewRoles = User::role('Registered')->firstOrFail();

    expect($user->fresh()
        ->hasVerifiedEmail())->toBeTrue()
        ->and($usersNewRoles->id)->toBe($registeredRole->id);
});
