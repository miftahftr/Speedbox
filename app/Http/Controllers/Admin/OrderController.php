<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Mulai kueri dasar
        $query = Order::query()->with(['customer', 'driver']);

        // --- Logika Pencarian (Search) ---
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                // Cari berdasarkan ID Pesanan
                $q->where('id', 'like', "%{$searchTerm}%")
                    // Atau cari berdasarkan nama Customer (melalui relasi)
                    ->orWhereHas('customer', function ($subQ) use ($searchTerm) {
                        $subQ->where('name', 'like', "%{$searchTerm}%");
                    })
                    // Atau cari berdasarkan nama Driver (melalui relasi)
                    ->orWhereHas('driver', function ($subQ) use ($searchTerm) {
                        $subQ->where('name', 'like', "%{$searchTerm}%");
                    });
            });
        }

        // --- Logika Pengurutan (Sort) ---
        if ($request->filled('sort') && $request->sort == 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->latest(); // Default: urutkan dari yang terbaru
        }

        // Eksekusi kueri dengan paginasi
        // appends() akan memastikan parameter search & sort tetap ada di link paginasi
        $orders = $query->paginate(15)->appends($request->query());

        return view('admin.orders.index', compact('orders'));
    }

    public function ratings(Request $request)
    {
        $query = User::query()->where('role', 'driver');

        // --- Logika Pencarian (Search) ---
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'like', "%{$searchTerm}%");
        }

        // Ambil data dengan kalkulasi rating
        $drivers = $query->withCount('driverRatings')
            ->withAvg('driverRatings', 'rating')
            ->orderByDesc('driver_ratings_avg_rating')
            ->paginate(10)
            ->appends($request->query());

        return view('admin.ratings.index', compact('drivers'));
    }
}