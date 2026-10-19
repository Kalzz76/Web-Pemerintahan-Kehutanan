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
        'deskripsi',
        'luas_ha',
        'geojson',
        'id_jenis_lahan',
    ];

    protected function casts(): array
    {
        return [
            'luas_ha' => 'float',
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

    public function primata()
    {
        return $this->belongsToMany(Primata::class, 'kawasan_primata', 'id_kawasan', 'id_primata');
    }

    public function tumbuhan()
    {
        return $this->belongsToMany(Tumbuhan::class, 'kawasan_tumbuhan', 'id_kawasan', 'id_tumbuhan');
    }
}
