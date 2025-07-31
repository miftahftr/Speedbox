<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Isi data user seperti biasa
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // ================= LOGIKA UPLOAD FOTO PROFIL =================
        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            // Simpan foto baru dan dapatkan path-nya
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }
        
        // ================= LOGIKA UPLOAD FOTO KENDARAAN =================
        if ($user->role == 'driver' && $request->hasFile('vehicle_photo')) {
            $driverProfile = $user->driverProfile;
            // Hapus foto lama jika ada
            if ($driverProfile->vehicle_photo_path) {
                Storage::disk('public')->delete($driverProfile->vehicle_photo_path);
            }
            // Simpan foto baru
            $path = $request->file('vehicle_photo')->store('vehicle-photos', 'public');
            $driverProfile->vehicle_photo_path = $path;
            $driverProfile->save();
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
