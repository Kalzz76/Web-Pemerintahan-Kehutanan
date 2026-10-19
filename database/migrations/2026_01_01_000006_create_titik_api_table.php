<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('titik_api', function (Blueprint $table) {
            $table->id();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->date('tanggal_deteksi');
            $table->string('waktu_deteksi');
            $table->string('kepercayaan');
            $table->string('sumber')->default('VIIRS');
            $table->timestamps();

            $table->unique(['latitude', 'longitude', 'tanggal_deteksi', 'waktu_deteksi'], 'titik_api_unik');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('titik_api');
    }
};
