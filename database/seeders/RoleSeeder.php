<?php

namespace Database\Seeders;

    use App\Models\Role;
    use Illuminate\Database\Seeder;

    class RoleSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run(): void
        {
            Role::factory()->create([
                'code' => 0,
                'auth_code' => 'super-admin',
                'name' => 'Super Administrator',
                'description' => 'Untethered Access',
            ]);

            Role::factory()->create([
                'code' => 1,
                'auth_code' => 'admin',
                'name' => 'Administrator',
                'description' => 'Administrator Access',
            ]);

            Role::factory()->create([
                'code' => 2,
                'auth_code' => 'manager',
                'name' => 'Manager',
                'description' => 'Manage Users and Resources',
            ]);

            Role::factory()->create([
                'code' => 3,
                'auth_code' => 'moderator',
                'name' => 'Moderator',
                'description' => 'Moderate Resources',
            ]);

            Role::factory()->create([
                'code' => 4,
                'auth_code' => 'registered',
                'name' => 'Registered User',
                'description' => 'Registered User',
            ]);

            Role::factory()->create([
                'code' => 5,
                'auth_code' => 'unverified',
                'name' => 'Unverified User',
                'description' => 'User has registered but not validated email',
            ]);
        }
    }
