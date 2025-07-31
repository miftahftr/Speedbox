<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleType;

class VehicleTypeSeeder extends Seeder
{
    public function run(): void
    {
        VehicleType::create([
            'name' => 'Pick-up Bak',
            'base_price' => 50000,
        ]);

        VehicleType::create([
            'name' => 'Truk Engkel',
            'base_price' => 100000,
        ]);
    }
}