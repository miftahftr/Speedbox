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
    Schema::table('driver_profiles', function (Blueprint $table) {
        $table->string('vehicle_photo_path')->nullable()->after('license_plate');
    });
}
public function down(): void
{
    Schema::table('driver_profiles', function (Blueprint $table) {
        $table->dropColumn('vehicle_photo_path');
    });
}
};
