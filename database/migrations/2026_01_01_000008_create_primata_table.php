<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('primata', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lokal');
            $table->string('nama_ilmiah');
            $table->string('status_konservasi');
            $table->boolean('dilindungi')->default(false);
            $table->text('habitat');
            $table->text('makanan');
            $table->text('ciri_khas');
            $table->text('deskripsi');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('primata');
    }
};
