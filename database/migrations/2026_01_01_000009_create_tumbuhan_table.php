<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tumbuhan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lokal');
            $table->string('nama_ilmiah');
            $table->string('jenis');
            $table->string('status_konservasi');
            $table->boolean('dilindungi')->default(false);
            $table->text('manfaat');
            $table->text('deskripsi');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tumbuhan');
    }
};
