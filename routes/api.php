<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LocationController; // <-- Import controller

// Rute untuk mendapatkan lokasi driver
Route::get('/driver-location/{driverProfile}', [LocationController::class, 'getLocation']);