<?php

declare(strict_types=1);

use App\Enums\RolesEnum;
use App\Models\User;

use function Pest\Laravel\actingAs;

// If User implements MustVerifyEmail then this will be the test for 'Unverified' Role users
it('redirects unverified users to login page', function (User $user, string $error) {
    actingAs($user)
        ->get(route('admin.users.index'))
        ->assertRedirect(url('email/verify'));
})->with([
    [fn () => User::role(RolesEnum::UNVERIFIED_USER)->first(), 'Unverified User'],
]);
