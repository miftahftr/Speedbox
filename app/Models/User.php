<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail; // Baris ini juga bisa dihapus jika tidak memakai verifikasi email
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// HAPUS BARIS INI: use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    // HAPUS 'HasApiTokens' DARI BARIS DI BAWAH INI
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relasi-relasi yang sudah kita buat sebelumnya tetap sama
    public function driverProfile()
    {
        return $this->hasOne(DriverProfile::class);
    }

    public function customerOrders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function driverOrders()
    {
        return $this->hasMany(Order::class, 'driver_id');
    }

    public function driverRatings()
    {
        return $this->hasMany(Rating::class, 'driver_id');
    }
}