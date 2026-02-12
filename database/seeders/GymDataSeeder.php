<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gym;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GymDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 0. Create a Default Gym
        $gym = Gym::create([
            'name' => 'Golden Gym',
            'subscription_expires_at' => now()->addYear(),
            'is_active' => true,
        ]);

        // Create Gym Admin for this gym
        User::create([
            'name' => 'Gym Manager',
            'email' => 'manager@goldengym.com',
            'password' => Hash::make('password'),
            'role' => 'gym_admin',
            'gym_id' => $gym->id,
        ]);

        // 1. Create Training Types
        $bodybuilding = \App\Models\TrainingType::create([
            'gym_id' => $gym->id,
            'name' => 'Bodybuilding', 
            'description' => 'Gym and Musculation access'
        ]);

        $kickboxing = \App\Models\TrainingType::create([
            'gym_id' => $gym->id,
            'name' => 'Kickboxing', 
            'description' => 'Kickboxing and Boxing classes'
        ]);

        // 2. Create Plans for Bodybuilding
        \App\Models\Plan::create([
            'gym_id' => $gym->id,
            'training_type_id' => $bodybuilding->id,
            'name' => '1 Month',
            'duration_days' => 30,
            'price' => 200.00,
            'is_active' => true,
        ]);

        \App\Models\Plan::create([
            'gym_id' => $gym->id,
            'training_type_id' => $bodybuilding->id,
            'name' => '3 Months',
            'duration_days' => 90,
            'price' => 600.00,
            'is_active' => true,
        ]);

        \App\Models\Plan::create([
            'gym_id' => $gym->id,
            'training_type_id' => $bodybuilding->id,
            'name' => '6 Months',
            'duration_days' => 180,
            'price' => 1200.00,
            'is_active' => true,
        ]);

        \App\Models\Plan::create([
            'gym_id' => $gym->id,
            'training_type_id' => $bodybuilding->id,
            'name' => '1 Year',
            'duration_days' => 365,
            'price' => 2400.00,
            'is_active' => true,
        ]);

        // 3. Create Plans for Kickboxing
        \App\Models\Plan::create([
            'gym_id' => $gym->id,
            'training_type_id' => $kickboxing->id,
            'name' => '1 Month',
            'duration_days' => 30,
            'price' => 150.00,
            'is_active' => true,
        ]);

        \App\Models\Plan::create([
            'gym_id' => $gym->id,
            'training_type_id' => $kickboxing->id,
            'name' => '3 Months',
            'duration_days' => 90,
            'price' => 450.00,
            'is_active' => true,
        ]);

        \App\Models\Plan::create([
            'gym_id' => $gym->id,
            'training_type_id' => $kickboxing->id,
            'name' => '6 Months',
            'duration_days' => 180,
            'price' => 900.00,
            'is_active' => true,
        ]);

        \App\Models\Plan::create([
            'gym_id' => $gym->id,
            'training_type_id' => $kickboxing->id,
            'name' => '1 Year',
            'duration_days' => 365,
            'price' => 1800.00,
            'is_active' => true,
        ]);
    }
}
