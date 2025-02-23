<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;
use Spatie\Permission\Models\Role;

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
        $registeredRole = Role::where('name', 'Registered')->firstOrFail();
        $event->user->syncRoles($registeredRole);
    }
}
