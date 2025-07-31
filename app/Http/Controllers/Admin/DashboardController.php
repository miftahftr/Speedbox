<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DriverProfile;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request) // <-- Tambahkan Request $request
    {
        // 1. Statistik Utama (Tidak berubah, tidak terpengaruh filter)
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');
        $totalCustomers = User::where('role', 'customer')->count();
        $activeDrivers = DriverProfile::whereIn('status', ['available', 'on_duty'])->count();

        // 2. Data Pesanan Terbaru (KINI DENGAN LOGIKA FILTER & SORT)
        $query = Order::query()->with(['customer', 'driver']);

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('id', 'like', "%{$searchTerm}%")
                    ->orWhereHas('customer', function ($subQ) use ($searchTerm) {
                        $subQ->where('name', 'like', "%{$searchTerm}%");
                    })
                    ->orWhereHas('driver', function ($subQ) use ($searchTerm) {
                        $subQ->where('name', 'like', "%{$searchTerm}%");
                    });
            });
        }

        if ($request->filled('sort') && $request->sort == 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->latest();
        }

        // Kita gunakan paginate(5) agar sesuai dengan layout dashboard
        $recentOrders = $query->paginate(5)->appends($request->query());

        // 3. Data Driver dengan Rating Tertinggi (Tidak berubah)
        $topDrivers = User::where('role', 'driver')
            ->withAvg('driverRatings', 'rating')
            ->orderByDesc('driver_ratings_avg_rating')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'totalCustomers',
            'activeDrivers',
            'recentOrders',
            'topDrivers'
        ));
    }
}