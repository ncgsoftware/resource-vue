<?php

namespace Tests;

use Database\Seeders\TestingUserRolePermissionsSeeder;
use Illuminate\Database\Events\DatabaseRefreshed;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Event;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // now de-register all the roles and permissions by clearing the permission cache
        // $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $this->withoutVite();

        /**  If you are using Laravel's LazilyRefreshDatabase trait, you most likely want to avoid seeding permissions before every test,
         * because that would negate the use of the LazilyRefreshDatabase trait.
         * To overcome this, you should wrap your seeder in an event listener for the DatabaseRefreshed event:
         */
        Event::listen(DatabaseRefreshed::class, function () {
            $this->artisan('db:seed', ['--class' => TestingUserRolePermissionsSeeder::class]);
            $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        });
    }
}
