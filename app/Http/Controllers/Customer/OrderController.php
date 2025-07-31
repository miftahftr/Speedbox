<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\DriverProfile;
use App\Models\Order;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function create()
    {
        $vehicleTypes = VehicleType::all();
        return view('customer.orders.create', compact('vehicleTypes'));
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'pickup_address' => 'required|string',
            'pickup_lat' => 'required|numeric',
            'pickup_lng' => 'required|numeric',
            'dropoff_address' => 'required|string',
            'dropoff_lat' => 'required|numeric',
            'dropoff_lng' => 'required|numeric',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
        ]);

        $pickupLat = $request->pickup_lat;
        $pickupLng = $request->pickup_lng;
        $maxDistance = 100; // Batas jarak pangkalan driver dari customer (dalam KM)

        // ================= LOGIKA BARU SESUAI SARAN ANDA =================

        // Langkah A: Ambil semua driver yang memenuhi syarat awal
        $availableDrivers = DriverProfile::where('status', 'available')
            ->where('vehicle_type_id', $request->vehicle_type_id)
            ->whereNotNull('address_lat') // <-- BERUBAH: Mencari berdasarkan alamat pangkalan
            ->get();

        if ($availableDrivers->isEmpty()) {
            return back()->with('error', 'Maaf, tidak ada driver yang tersedia saat ini.');
        }

        // Langkah B: Hitung jarak setiap driver dari lokasi pangkalannya
        $driversWithDistance = $availableDrivers->map(function ($driver) use ($pickupLat, $pickupLng) {
            // <-- BERUBAH: Menghitung jarak dari address_lat & address_lng
            $driver->distance = $this->calculateDistance($pickupLat, $pickupLng, $driver->address_lat, $driver->address_lng);
            return $driver;
        });

        // Langkah C: Saring driver yang pangkalannya di dalam batas maksimal
        $nearbyDrivers = $driversWithDistance->filter(function ($driver) use ($maxDistance) {
            return $driver->distance <= $maxDistance;
        });

        if ($nearbyDrivers->isEmpty()) {
            return back()->with('error', 'Maaf, tidak ada driver yang tersedia di dekat Anda saat ini.');
        }

        // Langkah D: Urutkan berdasarkan jarak dan ambil yang paling dekat
        $closestDriverProfile = $nearbyDrivers->sortBy('distance')->first();

        // ================= AKHIR LOGIKA BARU =================

        // Sisa proses sama seperti sebelumnya
        $distance = $this->calculateDistance($pickupLat, $pickupLng, $request->dropoff_lat, $request->dropoff_lng);
        $vehicleType = VehicleType::find($request->vehicle_type_id);
        $price = round(floatval($vehicleType->base_price) + ($distance * 2500));

        $order = Order::create([
            'customer_id' => Auth::id(),
            'driver_id' => $closestDriverProfile->user_id,
            'pickup_address' => $request->pickup_address,
            'pickup_lat' => $pickupLat,
            'pickup_lng' => $pickupLng,
            'dropoff_address' => $request->dropoff_address,
            'dropoff_lat' => $request->dropoff_lat,
            'dropoff_lng' => $request->dropoff_lng,
            'distance_km' => $distance,
            'total_price' => $price,
            'status' => 'paid',
        ]);

        return redirect()->route('orders.success', $order->id)->with('success', 'Pesanan berhasil dibuat!');
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        if ($lat1 == $lat2 && $lon1 == $lon2) {
            return 0;
        }
        $earthRadius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }

    public function history()
    {
        $orders = Order::where('customer_id', Auth::id())
            ->with('driver.driverProfile', 'rating')
            ->latest()
            ->paginate(10);

        return view('customer.orders.history', compact('orders'));
    }

    public function success(Order $order)
    {
        return view('customer.orders.success', compact('order'));
    }

    public function cancel(Order $order)
    {
        if ($order->customer_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak berhak membatalkan pesanan ini.');
        }

        if ($order->status !== 'paid') {
            return back()->with('error', 'Pesanan ini tidak dapat dibatalkan lagi.');
        }

        DB::transaction(function () use ($order) {
            $order->update(['status' => 'cancelled']);
            if ($order->driver && $order->driver->driverProfile) {
                $order->driver->driverProfile->update(['status' => 'available']);
            }
        });

        return redirect()->route('orders.history')->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function track(Order $order)
    {
        // Pastikan customer hanya bisa melacak pesanannya sendiri
        if ($order->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Ambil data order beserta relasi yang dibutuhkan
        // Termasuk menghitung rata-rata rating untuk driver yang bersangkutan
        $order->load([
            'driver.driverProfile.vehicleType',
            'driver' => function ($query) {
                $query->withAvg('driverRatings', 'rating');
            }
        ]);

        return view('customer.orders.track', compact('order'));
    }

}