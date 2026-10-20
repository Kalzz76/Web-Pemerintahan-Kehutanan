<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KawasanHutan extends Model
{
    use HasFactory;

    protected $table = 'kawasan_hutan';

    protected $fillable = [
        'nama',
        'kategori',
        'pengelola',
        'deskripsi',
        'luas_ha',
        'lat_pusat',
        'long_pusat',
        'geojson',
        'batas_resmi',
        'id_jenis_lahan',
    ];

    protected function casts(): array
    {
        return [
            'luas_ha' => 'float',
            'lat_pusat' => 'float',
            'long_pusat' => 'float',
            'batas_resmi' => 'boolean',
        ];
    }

    public function jenisLahan()
    {
        return $this->belongsTo(JenisLahan::class, 'id_jenis_lahan');
    }

    public function titikPenting()
    {
        return $this->hasMany(TitikPenting::class, 'id_kawasan');
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'id_kawasan');
    }

    public function kabupatenKota()
    {
        return $this->belongsToMany(KabupatenKota::class, 'kawasan_kabupaten', 'id_kawasan', 'id_kabupaten_kota');
    }

    public function primata()
    {
        return $this->belongsToMany(Primata::class, 'kawasan_primata', 'id_kawasan', 'id_primata');
    }

    public function tumbuhan()
    {
        return $this->belongsToMany(Tumbuhan::class, 'kawasan_tumbuhan', 'id_kawasan', 'id_tumbuhan');
    }
}
