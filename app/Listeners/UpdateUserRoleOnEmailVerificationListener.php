<?php

namespace App\Listeners;

use App\Models\Role;
use Illuminate\Auth\Events\Verified;

/**
 * Listens for Illuminate\Auth\Events\Verified to be dispatched
 * Updates a user role from 'unverified' to 'registered' when user verifies email address.
 */
class UpdateUserRoleOnEmailVerificationListener
{
    /**
     * @param  Verified  $event  //Illuminate\Auth\Events\Verified
     */
    public function handle(Verified $event): void
    {
        $role = Role::query()->where('auth_code', 'registered')->firstOrFail();
        $event->user->role()->associate($role)->save();
    }
}
