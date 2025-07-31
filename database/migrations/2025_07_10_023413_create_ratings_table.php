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
    Schema::create('ratings', function (Blueprint $table) {
        $table->id();

        // Relasi ke pesanan, customer, dan driver
        $table->foreignId('order_id')->constrained()->onDelete('cascade');
        $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('driver_id')->constrained('users')->onDelete('cascade');

        // Rating bintang 1-5
        $table->unsignedTinyInteger('rating');

        // Komentar atau ulasan (boleh kosong)
        $table->text('comment')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
