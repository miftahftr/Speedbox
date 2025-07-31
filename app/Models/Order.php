<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'driver_id',
        'pickup_address',
        'pickup_lat',
        'pickup_lng',
        'dropoff_address',
        'dropoff_lat',
        'dropoff_lng',
        'distance_km',
        'total_price',
        'status',
    ];

    protected $casts = [
        'notified_at' => 'datetime', // <-- Tambahkan ini
    ];

    // Relasi: Sebuah order dimiliki oleh satu customer (User)
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // Relasi: Sebuah order diambil oleh satu driver (User)
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
    
    // Relasi: Sebuah order memiliki satu rating
    public function rating()
    {
        return $this->hasOne(Rating::class);
    }
}