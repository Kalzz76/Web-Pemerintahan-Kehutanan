<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kawasan_hutan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi');
            $table->decimal('luas_ha', 10, 2)->nullable();
            $table->longText('geojson');
            $table->foreignId('id_jenis_lahan')->constrained('jenis_lahan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kawasan_hutan');
    }
};
