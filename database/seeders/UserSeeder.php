<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\DriverProfile;
use App\Models\VehicleType;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat Admin
        User::factory()->admin()->create([
            'name' => 'Admin SpeedBox',
            'email' => 'admin@speedbox.com',
        ]);

        // 2. Membuat 5 Customer
        User::factory()->count(5)->create();

        // 3. Membuat 10 Driver dengan profilnya
        $vehicleTypes = VehicleType::all();

        User::factory()->count(10)->driver()->create()->each(function ($user) use ($vehicleTypes) {
            DriverProfile::create([
                'user_id' => $user->id,
                'vehicle_type_id' => $vehicleTypes->random()->id,
                'license_plate' => 'AB ' . fake()->numberBetween(1000, 9999) . ' XYZ',
                'phone_number' => fake()->phoneNumber(),
                'address' => fake()->address(),
                'address_lat' => fake()->latitude(),
                'address_lng' => fake()->longitude(),
                'status' => 'available',
            ]);
        });
    }
}