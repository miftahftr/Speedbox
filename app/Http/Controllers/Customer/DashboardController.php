<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil pesanan terakhir dari user
        $latestOrder = Order::where('customer_id', $user->id)
            ->latest()
            ->first();

        // Hitung jumlah pesanan yang sudah selesai
        $completedOrdersCount = Order::where('customer_id', $user->id)
            ->where('status', 'completed')
            ->count();

        return view('dashboard', compact('latestOrder', 'completedOrdersCount'));
    }
}