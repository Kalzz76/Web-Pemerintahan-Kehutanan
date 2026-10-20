<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kabupaten_kota', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->string('jenis');
            $table->timestamps();
        });

        Schema::create('kawasan_kabupaten', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kawasan')->constrained('kawasan_hutan')->cascadeOnDelete();
            $table->foreignId('id_kabupaten_kota')->constrained('kabupaten_kota')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::table('kawasan_hutan', function (Blueprint $table) {
            $table->string('kategori')->default('Lainnya')->after('nama');
            $table->string('pengelola')->nullable()->after('kategori');
            $table->decimal('lat_pusat', 10, 7)->nullable()->after('luas_ha');
            $table->decimal('long_pusat', 10, 7)->nullable()->after('lat_pusat');
            $table->boolean('batas_resmi')->default(0)->after('geojson');
        });

        Schema::table('titik_penting', function (Blueprint $table) {
            $table->foreignId('id_kabupaten_kota')->nullable()->after('id_kawasan')->constrained('kabupaten_kota')->nullOnDelete();
        });

        Schema::table('laporan', function (Blueprint $table) {
            $table->foreignId('id_kabupaten_kota')->nullable()->after('id_kawasan')->constrained('kabupaten_kota')->nullOnDelete();
        });

        Schema::table('pengaturan_hutan', function (Blueprint $table) {
            if (Schema::hasColumn('pengaturan_hutan', 'radius_titik_api_km')) {
                $table->dropColumn('radius_titik_api_km');
            }
            $table->decimal('bbox_barat', 10, 7)->default(106.36)->after('zoom_awal');
            $table->decimal('bbox_selatan', 10, 7)->default(-7.83)->after('bbox_barat');
            $table->decimal('bbox_timur', 10, 7)->default(108.85)->after('bbox_selatan');
            $table->decimal('bbox_utara', 10, 7)->default(-5.90)->after('bbox_timur');
            $table->decimal('lat_pusat', 10, 7)->default(-6.87)->change();
            $table->decimal('long_pusat', 10, 7)->default(107.60)->change();
            $table->integer('zoom_awal')->default(8)->change();
        });
    }

    public function down(): void
    {
        Schema::table('pengaturan_hutan', function (Blueprint $table) {
            $table->dropColumn(['bbox_barat', 'bbox_selatan', 'bbox_timur', 'bbox_utara']);
            $table->integer('radius_titik_api_km')->default(30);
            $table->decimal('lat_pusat', 10, 7)->default(-6.8921)->change();
            $table->decimal('long_pusat', 10, 7)->default(108.4112)->change();
            $table->integer('zoom_awal')->default(13)->change();
        });

        Schema::table('laporan', function (Blueprint $table) {
            $table->dropForeign(['id_kabupaten_kota']);
            $table->dropColumn('id_kabupaten_kota');
        });

        Schema::table('titik_penting', function (Blueprint $table) {
            $table->dropForeign(['id_kabupaten_kota']);
            $table->dropColumn('id_kabupaten_kota');
        });

        Schema::table('kawasan_hutan', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'pengelola', 'lat_pusat', 'long_pusat', 'batas_resmi']);
        });

        Schema::dropIfExists('kawasan_kabupaten');
        Schema::dropIfExists('kabupaten_kota');
    }
};
