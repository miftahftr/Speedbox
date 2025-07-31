<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'customer_id',
        'driver_id',
        'rating',
        'comment',
    ];
    
    // Relasi: Sebuah rating terikat pada satu order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}