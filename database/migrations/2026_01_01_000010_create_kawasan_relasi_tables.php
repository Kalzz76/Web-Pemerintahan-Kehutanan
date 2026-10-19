<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kawasan_primata', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kawasan')->constrained('kawasan_hutan')->cascadeOnDelete();
            $table->foreignId('id_primata')->constrained('primata')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('kawasan_tumbuhan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kawasan')->constrained('kawasan_hutan')->cascadeOnDelete();
            $table->foreignId('id_tumbuhan')->constrained('tumbuhan')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kawasan_tumbuhan');
        Schema::dropIfExists('kawasan_primata');
    }
};
