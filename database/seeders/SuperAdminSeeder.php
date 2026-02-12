<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if super admin already exists to avoid duplicates
        if (!User::where('email', 'super@admin.com')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'super@admin.com',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'gym_id' => null,
            ]);
        }
    }
}
