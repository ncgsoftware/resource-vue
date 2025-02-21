<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Http\Resources\UserAdministrationResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ?Role $role = null)
    {
        Gate::authorize('viewAny', User::class);

        $users = User::with('role')
            // Users can't see users with higher roles than themselves
            ->whereDoesntHave('role', function ($query) use ($request) {
                $query->where('code', '<', $request->user()->role->code);
            })
//                ->when(true, function (Builder $query) use ($request) {
//                    $query->whereDoesntHave('role', function ($query) use ($request) {
//                        $query->where('code', '<', $request->user()->role->code);
//                    });
//                })
            // If we have a specific role requested, limit to users of that role only
            ->when($role, fn (Builder $query) => $query->whereBelongsTo($role))
            // If search query is requested
            ->when(
                $request->query('query'),
                fn (Builder $query) => $query
                    ->whereAny(['name', 'email'], 'like', '%'.$request->query('query').'%'))
            ->paginate()
            ->appends(request()->only(['query']));

        $applicableRoles = Role::query()->where('code', '>=', $request->user()->role->code)->get([
            'id',
            'name',
            'auth_code',
        ]);

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
