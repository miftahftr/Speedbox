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
    Schema::create('vehicle_types', function (Blueprint $table) {
        $table->id(); // Primary Key
        $table->string('name'); // Contoh: "Pick-up Bak", "Truk Engkel"
        $table->decimal('base_price', 10, 2); // Harga dasar
        $table->string('image_url')->nullable(); // URL gambar kendaraan
        $table->timestamps(); // Kolom created_at dan updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_types');
    }
};
