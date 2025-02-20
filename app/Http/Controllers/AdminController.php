<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        Gate::authorize('viewAdminDashboard', User::class);

        return Inertia::render('Admin/Index', []);
    }
}
