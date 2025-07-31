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
        Schema::create('driver_profiles', function (Blueprint $table) {
            $table->id();
    
            // Kunci asing ke tabel 'users'
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Kunci asing ke tabel 'vehicle_types'
            $table->foreignId('vehicle_type_id')->constrained()->onDelete('cascade');
    
            $table->string('license_plate'); // Nomor polisi
            $table->string('phone_number'); // Nomor HP
            $table->text('address'); // Alamat "pangkalan" driver
            $table->decimal('address_lat', 10, 8); // Latitude pangkalan
            $table->decimal('address_lng', 11, 8); // Longitude pangkalan
            $table->decimal('current_lat', 10, 8)->nullable(); // Latitude live
            $table->decimal('current_lng', 11, 8)->nullable(); // Longitude live
            
            // Status live driver
            $table->enum('status', ['available', 'on_duty', 'offline'])->default('offline');
            $table->index('status');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_profiles');
    }
};
