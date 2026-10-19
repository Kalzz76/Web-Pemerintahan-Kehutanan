<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prediksi_api', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_laporan')->nullable()->constrained('laporan')->nullOnDelete();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->foreignId('id_jenis_lahan')->constrained('jenis_lahan');
            $table->decimal('arah_angin', 8, 2);
            $table->decimal('kecepatan_angin', 8, 2);
            $table->decimal('kelembapan', 8, 2);
            $table->decimal('curah_hujan', 8, 2);
            $table->decimal('laju_efektif', 10, 2);
            $table->longText('poligon_1jam');
            $table->longText('poligon_3jam');
            $table->longText('poligon_6jam');
            $table->decimal('luas_1jam', 10, 2);
            $table->decimal('luas_3jam', 10, 2);
            $table->decimal('luas_6jam', 10, 2);
            $table->text('area_terancam')->nullable();
            $table->boolean('tampil_publik')->default(false);
            $table->foreignId('id_admin')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prediksi_api');
    }
};
