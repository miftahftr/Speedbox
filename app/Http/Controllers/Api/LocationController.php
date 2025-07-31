<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DriverProfile;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getLocation(DriverProfile $driverProfile)
    {
        return response()->json([
            'latitude' => $driverProfile->current_lat,
            'longitude' => $driverProfile->current_lng,
        ]);
    }
}