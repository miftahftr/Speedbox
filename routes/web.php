<?php

use Illuminate\Support\Facades\Route;
// Import controller kita di bagian atas
use App\Http\Controllers\Customer\RatingController;
use App\Http\Controllers\Driver\DashboardController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rute untuk Landing Page
Route::get('/', [LandingPageController::class, 'index'])->name('landing');

// Rute bawaan Breeze untuk dashboard (setelah login)
Route::get('/dashboard', [CustomerDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');
// Rute bawaan Breeze untuk profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // RUTE UNTUK CUSTOMER
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/success/{order}', [OrderController::class, 'success'])->name('orders.success');
    Route::get('/my-orders', [OrderController::class, 'history'])->name('orders.history');
    Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');
    Route::get('/track-order/{order}', [OrderController::class, 'track'])->name('orders.track');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/driver-location/{driverProfile}', [LocationController::class, 'getLocation'])->name('driver.location');
});

// GRUP RUTE UNTUK ADMIN
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Rute untuk manajemen driver
    Route::get('/drivers', [DriverController::class, 'index'])->name('drivers.index');
    Route::get('/drivers/create', [DriverController::class, 'create'])->name('drivers.create'); // <-- Rute untuk menampilkan form
    Route::post('/drivers', [DriverController::class, 'store'])->name('drivers.store');
    Route::get('/drivers/{user}/edit', [DriverController::class, 'edit'])->name('drivers.edit'); // <-- Rute form edit
    Route::put('/drivers/{user}', [DriverController::class, 'update'])->name('drivers.update'); // <-- Rute proses update
    Route::delete('/drivers/{user}', [DriverController::class, 'destroy'])->name('drivers.destroy'); // <-- Rute Hapus
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/ratings', [AdminOrderController::class, 'ratings'])->name('ratings.index'); // <-- Rute monitor rating
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});

// GRUP RUTE UNTUK DRIVER
Route::middleware(['auth', 'driver'])->prefix('driver')->name('driver.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/status', [DashboardController::class, 'updateStatus'])->name('status.update');
    Route::post('/orders/{order}/accept', [DashboardController::class, 'acceptOrder'])->name('orders.accept');
    Route::post('/orders/{order}/complete', [DashboardController::class, 'completeOrder'])->name('orders.complete');
    Route::post('/location', [DashboardController::class, 'updateLocation'])->name('location.update');
    Route::get('/history', [DashboardController::class, 'history'])->name('history');
});

require __DIR__ . '/auth.php';