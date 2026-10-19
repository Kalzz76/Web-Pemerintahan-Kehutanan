<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan_hutan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_aplikasi');
            $table->string('nama_instansi');
            $table->string('slogan');
            $table->text('deskripsi_singkat');
            $table->text('alamat');
            $table->string('email');
            $table->string('telepon');
            $table->string('logo')->nullable();
            $table->decimal('lat_pusat', 10, 7);
            $table->decimal('long_pusat', 10, 7);
            $table->integer('zoom_awal')->default(12);
            $table->integer('radius_titik_api_km')->default(30);
            $table->dateTime('terakhir_ambil_firms')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_hutan');
    }
};
