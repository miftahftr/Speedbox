<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vehicle_type_id',
        'license_plate',
        'vehicle_photo_path',
        'phone_number',
        'address',
        'address_lat',
        'address_lng',
        'current_lat',
        'current_lng',
        'status',
    ];

    // Relasi: Sebuah profil driver dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Sebuah profil driver memiliki satu jenis kendaraan
    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }
}