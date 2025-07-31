<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $order = Order::find($request->order_id);

        // Pastikan customer hanya memberi rating pada pesanannya sendiri
        if ($order->customer_id !== Auth::id()) {
            return back()->with('error', 'Ini bukan pesanan Anda.');
        }

        // Buat rating
        Rating::create([
            'order_id' => $order->id,
            'customer_id' => $order->customer_id,
            'driver_id' => $order->driver_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}