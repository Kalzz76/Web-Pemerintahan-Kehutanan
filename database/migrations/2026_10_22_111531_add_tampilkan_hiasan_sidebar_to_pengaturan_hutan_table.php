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
        Schema::table('pengaturan_hutan', function (Blueprint $table) {
            $table->boolean('tampilkan_hiasan_sidebar')->default(true)->after('logo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaturan_hutan', function (Blueprint $table) {
            $table->dropColumn('tampilkan_hiasan_sidebar');
        });
    }
};
