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
    //use WithPagination;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Role $role = null)
    {
        Gate::authorize('viewAny', User::class);

        $users = User::with('role')
            ->when($role, fn(Builder $query) => $query->whereBelongsTo($role))
            ->when(
                $request->query('query'),
                fn(Builder $query) => $query
                    ->whereAny(['name', 'email'], 'like', '%'.$request->query('query').'%'))
            ->paginate()
            ->appends(request()->only(['query']));

        return Inertia::render('Admin/Users/Index', [
            'users' => UserAdministrationResource::collection($users),
            'roles' => fn() => RoleResource::collection(Role::all('id', 'name', 'auth_code')),
            'selectedRole' => fn() => $role ? RoleResource::make($role) : null,
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
