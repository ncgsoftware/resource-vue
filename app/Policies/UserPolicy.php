<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role->auth_code === 'super-admin'
            || $user->role->auth_code === 'admin'
            || $user->role->auth_code === 'manager';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Super Admins can only edit themselves through Jetstream profile
        if($model->role->auth_code === 'super-admin') {
            return false;
        }

        return $user->role->auth_code === 'super-admin'
            || $user->role->auth_code === 'admin'
            || $user->role->auth_code === 'manager';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // No one can delete a super admin
        if($model->role->auth_code === 'super-admin') {
            return false;
        }

        // Only super admins can delete admins
        if($model->role->auth_code === 'admin') {
            if($user->role->auth_code !== 'super-admin') {
                return false;
            }
        }

        return $user->role->auth_code === 'super-admin'
            || $user->role->auth_code === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
