<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $driver = Auth::user();
        $activeOrder = Order::where('driver_id', $driver->id)
            ->whereIn('status', ['paid', 'on_the_way'])
            ->first();

        return view('driver.dashboard', [
            'driver' => $driver,
            'activeOrder' => $activeOrder,
        ]);
    }

    public function updateStatus(Request $request)
    {
        $request->validate(['status' => 'required|in:available,offline']);
        Auth::user()->driverProfile->update(['status' => $request->status]);
        return back()->with('success', 'Status Anda berhasil diperbarui.');
    }


    public function acceptOrder(Order $order)
    {
        if ($order->driver_id !== Auth::id()) {
            return back()->with('error', 'Ini bukan pesanan Anda.');
        }

        DB::transaction(function () use ($order) {
            $order->update(['status' => 'on_the_way']);
            Auth::user()->driverProfile->update(['status' => 'on_duty']);
        });

        return redirect()->route('driver.dashboard')->with('success', 'Pesanan diterima! Anda sedang dalam tugas.');
    }

    public function completeOrder(Order $order)
    {
        if ($order->driver_id !== Auth::id()) {
            return back()->with('error', 'Ini bukan pesanan Anda.');
        }

        DB::transaction(function () use ($order) {
            $order->update(['status' => 'completed']);
            Auth::user()->driverProfile->update(['status' => 'available']);
        });

        return redirect()->route('driver.dashboard')->with('success', 'Pesanan telah diselesaikan!');
    }

    public function updateLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        Auth::user()->driverProfile()->update([
            'current_lat' => $request->latitude,
            'current_lng' => $request->longitude,
        ]);

        // Kirim response sukses (tidak wajib, tapi praktik yang baik)
        return response()->json(['message' => 'Location updated successfully.']);
    }

    public function history(Request $request)
    {
        $driver = Auth::user();
        $query = Order::where('driver_id', $driver->id)
            ->with(['customer', 'rating'])
            // Hanya ambil pesanan yang sudah tidak aktif
            ->whereIn('status', ['completed', 'cancelled']);

        // Logika untuk filter berdasarkan tab
        if ($request->filled('status')) {
            if ($request->status == 'completed') {
                $query->where('status', 'completed');
            } elseif ($request->status == 'cancelled') {
                $query->where('status', 'cancelled');
            }
        }

        $orders = $query->latest()->paginate(10)->appends($request->query());

        return view('driver.history', compact('orders'));
    }
}