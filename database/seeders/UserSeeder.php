<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'sa@example.com',
            'role_id' => 1,
            'profile_photo_path' => 'profile-photos/QTTqsSelOQPcRhYbY1QpYAjnoGkVSJdQ6QvsqHHC.png'
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role_id' => 2,
            'profile_photo_path' => 'profile-photos/O98ssPD7Q6U20okjc2mjaCygWdo7IX3KXW9hJv9z.png'
        ]);

        User::factory()->create([
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'role_id' => 3,
            'profile_photo_path' => 'profile-photos/mRHZkhBSBB61UodApJAsZojOnTqoHm2L0LiTXwpR.png'
        ]);

        User::factory()->create([
            'name' => 'Moderator',
            'email' => 'moderator@example.com',
            'role_id' => 4,
            'profile_photo_path' => 'profile-photos/MKL3HrDHBOq3S2cvLJ0Ih6lGgpCJGYjvD3YDZADj.png'
        ]);

        User::factory()->create([
            'name' => 'Registered User', //Registered and Verified
            'email' => 'reg@example.com',
            'role_id' => 5,
            'profile_photo_path' => 'profile-photos/CQWOpDDLnwfZb4a3B1Ld9mXDuiJw74pjQPy1u6nm.png',
        ]);

        User::factory()->create([
            'name' => 'Unverified User', //Registered, but unverified
            'email' => 'unver@example.com',
            'email_verified_at' => null,
            'role_id' => 6,
            'profile_photo_path' => 'profile-photos/s1dQR5uljkSDKNoRpEAOFikYSbwpJpehC9p3FwrY.png'
        ]);
    }
}
