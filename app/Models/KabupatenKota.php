<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KabupatenKota extends Model
{
    use HasFactory;

    protected $table = 'kabupaten_kota';

    protected $fillable = [
        'nama',
        'jenis',
    ];

    public function kawasanHutan()
    {
        return $this->belongsToMany(KawasanHutan::class, 'kawasan_kabupaten', 'id_kabupaten_kota', 'id_kawasan');
    }

    public function titikPenting()
    {
        return $this->hasMany(TitikPenting::class, 'id_kabupaten_kota');
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'id_kabupaten_kota');
    }
}
