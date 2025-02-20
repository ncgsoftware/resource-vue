<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

/**
 * General Administration Views Controller
 */
class AdminController extends Controller
{
    /**
     * Admin dashboard view
     * @param  Request  $request
     * @return \Inertia\Response
     */
    public function dashboard(Request $request)
    {
        Gate::authorize('viewAdminDashboard', User::class);

        return Inertia::render('Admin/Index', []);
    }
}
