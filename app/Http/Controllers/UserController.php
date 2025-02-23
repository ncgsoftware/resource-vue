<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Http\Resources\UserAdministrationResource;
use App\Models\User;
use App\Traits\DetermineRoleHierarchy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use DetermineRoleHierarchy;

    /**
     * Display a listing of Users.
     * Listing available depends on user's role level. A user can not see Roles with higher permissions than their own.
     * If a specific role is given, it filters to return only users with those roles.
     * It will return users within the query search parameter if provided.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request, ?Role $role = null)
    {
        Gate::authorize('viewAny', User::class);

        $allowableRoles = $this->determineRolesUserIsAllowedToDisplay($request->user());
        $applicableRoles = Role::whereIn('name', $allowableRoles)->get();

        $users = User::with('roles')
            ->whereHas('roles', function (Builder $query) use ($allowableRoles, $role) {
                $query->whereIn('name', $allowableRoles)
                    // If we have specified a role, filter for this role.
                    ->when($role, function (Builder $query) use ($role) {
                        return $query->whereIn('id', [$role->id]);
                    });
            })
            ->when(
                $request->query('query'),
                fn (Builder $query) => $query
                    ->whereAny(['name', 'email'], 'like', '%'.$request->query('query').'%'))
            ->paginate()
            ->appends(request()->only(['query']));

        return Inertia::render('Admin/Users/Index', [
            'users' => UserAdministrationResource::collection($users),
            'roles' => fn () => RoleResource::collection($applicableRoles),
            'selectedRole' => fn () => $role ? RoleResource::make($role) : null,
            'query' => $request->query('query'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
