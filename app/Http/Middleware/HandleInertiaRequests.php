<?php

namespace App\Http\Middleware;

    use App\Models\User;
    use Illuminate\Http\Request;
    use Inertia\Middleware;

    class HandleInertiaRequests extends Middleware
    {
        /**
         * The root template that's loaded on the first page visit.
         *
         * @see https://inertiajs.com/server-side-setup#root-template
         *
         * @var string
         */
        protected $rootView = 'app';

        /**
         * Determines the current asset version.
         *
         * @see https://inertiajs.com/asset-versioning
         */
        public function version(Request $request): ?string
        {
            return parent::version($request);
        }

        /**
         * Define the props that are shared by default.
         *
         * @see https://inertiajs.com/shared-data
         *
         * @return array<string, mixed>
         */
        public function share(Request $request): array
        {
            return array_merge(parent::share($request), [
                // Lazily...
                'auth.user' => function () use ($request) {
                    $attributes = null;

                    if ($request->user()) {
                        $attributes = $request->user()->only([
                            'id',
                            'name',
                            'profile_photo_path',
                            'profile_photo_url',
                            'auth_code'
                        ]);

                        $attributes['permissions']['view_admin_dashboard'] = $request->user()?->can('viewAdminDashboard',
                            User::class);

                        $request->routeIs('admin.*')
                            ? $attributes['permissions']['view_admin_user_list'] = $request->user()?->can('viewAny',
                                User::class)
                            : null;
//                    if ($request->routeIs('admin.*')){
//                        $attributes['permissions']['view_admin_user_list'] = $request->user()?->can('viewAny', User::class);
//                    }
                    }

                    return $attributes;
//                return $request->user()
//                    ? $request->user()->only(['id', 'name', 'profile_photo_path', 'profile_photo_url', 'auth_code'])
//                    : null;
                },
            ]);
        }
    }
