<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
    
            // Relasi ke customer (dari tabel users)
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            
            // Relasi ke driver (juga dari tabel users)
            $table->foreignId('driver_id')->constrained('users')->onDelete('cascade');
    
            $table->text('pickup_address');
            $table->decimal('pickup_lat', 10, 8);
            $table->decimal('pickup_lng', 11, 8);
    
            $table->text('dropoff_address');
            $table->decimal('dropoff_lat', 10, 8);
            $table->decimal('dropoff_lng', 11, 8);
            
            $table->decimal('distance_km', 8, 2);
            $table->decimal('total_price', 12, 2);
    
            // Status pesanan
            $table->enum('status', ['pending', 'paid', 'on_the_way', 'completed', 'cancelled'])->default('pending');
            $table->index('status');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
