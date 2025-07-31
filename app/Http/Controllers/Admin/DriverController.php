<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VehicleType; // <-- Import model ini
use App\Models\DriverProfile; // <-- Import model ini
use Illuminate\Support\Facades\DB; // <-- Import DB Facade
use Illuminate\Support\Facades\Hash; // <-- Import Hash Facade

class DriverController extends Controller
{
    public function index(Request $request) // <-- Tambahkan Request $request
    {
        $query = User::query()->where('role', 'driver')->with('driverProfile.vehicleType');

        // --- Logika Pencarian (Search) ---
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        $drivers = $query->latest()->paginate(10)->appends($request->query());

        return view('admin.drivers.index', compact('drivers'));
    }

    // Method untuk menampilkan form
    public function create()
    {
        $vehicleTypes = VehicleType::all(); // Ambil semua jenis kendaraan
        return view('admin.drivers.create', compact('vehicleTypes'));
    }

    // Method untuk menyimpan data driver baru
    public function store(Request $request)
    {
        // 1. Validasi data input (termasuk data lokasi baru)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'address' => 'required|string',
            'address_lat' => 'required|numeric',
            'address_lng' => 'required|numeric',
            'phone_number' => 'required|string',
            'license_plate' => 'required|string',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
        ]);

        // 2. Gunakan DB Transaction untuk memastikan semua data tersimpan
        DB::transaction(function () use ($request) {
            // Buat data User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'driver',
            ]);

            // Buat data DriverProfile (dengan data lokasi)
            DriverProfile::create([
                'user_id' => $user->id,
                'phone_number' => $request->phone_number,
                'license_plate' => $request->license_plate,
                'vehicle_type_id' => $request->vehicle_type_id,
                'address' => $request->address,
                'address_lat' => $request->address_lat,
                'address_lng' => $request->address_lng,
            ]);
        });

        // 3. Redirect kembali dengan pesan sukses
        return redirect()->route('admin.drivers.index')->with('success', 'Driver baru berhasil ditambahkan.');
    }

    // Method untuk menampilkan form edit
    public function edit(User $user)
    {
        // Pastikan user yang diedit adalah driver
        if ($user->role !== 'driver') {
            return redirect()->route('admin.drivers.index')->with('error', 'User bukan seorang driver.');
        }

        $vehicleTypes = VehicleType::all();
        return view('admin.drivers.edit', compact('user', 'vehicleTypes'));
    }

    // Method untuk memproses update
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'required|string',
            'license_plate' => 'required|string',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
        ]);

        DB::transaction(function () use ($request, $user) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Jika password diisi, update password
            if ($request->filled('password')) {
                $user->update(['password' => Hash::make($request->password)]);
            }

            $user->driverProfile->update([
                'phone_number' => $request->phone_number,
                'license_plate' => $request->license_plate,
                'vehicle_type_id' => $request->vehicle_type_id,
            ]);
        });

        return redirect()->route('admin.drivers.index')->with('success', 'Data driver berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Hapus user. Karena ada onDelete('cascade') di migrasi,
        // driver_profile yang terhubung akan ikut terhapus.
        $user->delete();

        return redirect()->route('admin.drivers.index')->with('success', 'Driver berhasil dihapus.');
    }
}