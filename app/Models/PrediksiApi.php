<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrediksiApi extends Model
{
    use HasFactory;

    protected $table = 'prediksi_api';

    protected $fillable = [
        'id_laporan',
        'latitude',
        'longitude',
        'id_jenis_lahan',
        'arah_angin',
        'kecepatan_angin',
        'kelembapan',
        'curah_hujan',
        'laju_efektif',
        'poligon_1jam',
        'poligon_3jam',
        'poligon_6jam',
        'luas_1jam',
        'luas_3jam',
        'luas_6jam',
        'area_terancam',
        'tampil_publik',
        'id_admin',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'arah_angin' => 'float',
            'kecepatan_angin' => 'float',
            'kelembapan' => 'float',
            'curah_hujan' => 'float',
            'laju_efektif' => 'float',
            'luas_1jam' => 'float',
            'luas_3jam' => 'float',
            'luas_6jam' => 'float',
            'tampil_publik' => 'boolean',
        ];
    }

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'id_laporan');
    }

    public function jenisLahan()
    {
        return $this->belongsTo(JenisLahan::class, 'id_jenis_lahan');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin');
    }
}
