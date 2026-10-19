<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('jenis');
            $table->string('jenis_hewan')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->text('deskripsi');
            $table->string('foto')->nullable();
            $table->string('nama_pelapor')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('status')->default('Baru');
            $table->text('catatan_admin')->nullable();
            $table->foreignId('id_kawasan')->nullable()->constrained('kawasan_hutan')->nullOnDelete();
            $table->foreignId('id_admin')->nullable()->constrained('users')->nullOnDelete();
            $table->string('ip_pelapor');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
